<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\AnneeAcademique;
use App\Models\Bulletin;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Note;
use App\Models\PeriodeAcademique;
use App\Models\Professeur;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfesseurController extends Controller
{
    public function affecterClasses(Request $request, Professeur $professeur)
    {
        $request->validate([
            'classes' => 'required|array',
            'classes.*' => 'exists:classes,id',
        ]);

        $professeur->classes()->sync($request->classes);

        return back()->with('success', 'Classes affectées avec succès');
    }

    public function index()
    {
        $professeurs = Professeur::with('user')->get();

        return view('admin.professeurs.index', compact('professeurs'));
    }

    public function dashboard()
    {
        $annees = AnneeAcademique::all();

        return view('professeur.dashboard', compact('annees'));
    }

    public function mesClasses($anneeId)
    {
        $user = Auth::user();

        if (! $user || ! $user->professeur) {
            abort(403, "Accès non autorisé : Vous n'etes pas un professeur.");
        }

        $professeurId = $user->professeur->id;

        $classes = Affectation::with(['classe', 'matiere'])
            ->where('professeur_id', $professeurId)
            ->where('annee_academique_id', $anneeId)
            ->get()
            ->groupBy('classe_id');

        $annee = AnneeAcademique::findOrFail($anneeId);

        return view('professeur.classes', compact('classes', 'annee'));
    }

    public function elevesParClasse($anneeId, $classeId)
    {
        $professeurId = Auth::user()->professeur->id;

        $affectations = Affectation::where('classe_id', $classeId)
            ->where('professeur_id', $professeurId)
            ->where('annee_academique_id', $anneeId)
            ->with([
                'matiere' => function ($query) use ($classeId) {
                    $query->with([
                        'ClasseMatiereProfesseur' => function ($q) use ($classeId) {
                            $q->where('classe_id', $classeId);
                        },
                    ]);
                },
            ])
            ->get();

        $eleves = Eleve::with('user')
            ->where('classe_id', $classeId)
            ->where('annee_academique_id', $anneeId)
            ->get();

        $classe = Classe::findOrFail($classeId);
        $annee = AnneeAcademique::findOrFail($anneeId);
        $periodes = PeriodeAcademique::where('annee_academique_id', $anneeId)->get();

        // Récupere la matière sélectionnée
        $selectedMatiereId = request('matiere_id', $affectations->first()->matiere->id ?? null);
        $selectedPeriodeId = request('periode_id', $periodes->first()->id ?? null);

        // Récupere toutes les notes existantes pour la période sélectionnée
        $notesExistantes = [];
        if ($selectedMatiereId && $selectedPeriodeId) {
            $notes = Note::whereIn('eleve_id', $eleves->pluck('id'))
                ->where('matiere_id', $selectedMatiereId)
                ->where('periode_id', $selectedPeriodeId)
                ->get();

            foreach ($notes as $note) {
                $notesExistantes[$note->eleve_id.'_'.$note->nom_evaluation] = $note;
            }
        }

        return view('professeur.eleves', compact(
            'classe',
            'eleves',
            'affectations',
            'annee',
            'periodes',
            'notesExistantes',
            'selectedMatiereId',
            'selectedPeriodeId'
        ));
    }


public function listeElevesAMigrer($anneeId, $classeId)
{
    $classe = Classe::findOrFail($classeId);
    $annee = AnneeAcademique::findOrFail($anneeId);

    // 🔸 Seuil dynamique
    $seuilAdmission = request()->query('seuil', 10);

    $elevesAdmis = Eleve::where('classe_id', $classeId)
        ->where('annee_academique_id', $anneeId)
        ->whereHas('bulletins', function ($q) use ($seuilAdmission) {
            $q->where('moyenne_generale', '>=', $seuilAdmission);
        })
        ->with(['user', 'bulletins' => function ($q) {
            $q->latest('periode_id')->limit(1);
        }])
        ->get()
        ->each(function ($eleve) {
            $eleve->moyenne_generale = $eleve->bulletins->first()->moyenne_generale ?? 'N/A';
        });

    $elevesRefuses = Eleve::where('classe_id', $classeId)
        ->where('annee_academique_id', $anneeId)
        ->whereHas('bulletins', function ($q) use ($seuilAdmission) {
            $q->where('moyenne_generale', '<', $seuilAdmission);
        })
        ->with(['user', 'bulletins' => function ($q) {
            $q->latest('periode_id')->limit(1);
        }])
        ->get()
        ->each(function ($eleve) {
            $eleve->moyenne_generale = $eleve->bulletins->first()->moyenne_generale ?? 'N/A';
        });

    return view('admin.migration.index', compact('classe', 'annee', 'elevesAdmis', 'elevesRefuses', 'seuilAdmission'));
}

    public function calculerMoyenneAnnuelle($anneeId, $classeId)
    {
        $periodes = PeriodeAcademique::where('annee_academique_id', $anneeId)->get();
        $nbPeriodes = $periodes->count();

        Eleve::where('classe_id', $classeId)
            ->where('annee_academique_id', $anneeId)
            ->with(['bulletins' => function ($q) use ($periodes) {
                $q->whereIn('periode_id', $periodes->pluck('id'));
            }])
            ->get()
            ->each(function ($eleve) use ($nbPeriodes) {
                $moyenneGenerale = $nbPeriodes > 0
                    ? $eleve->bulletins->avg('moyenne_periodique')
                    : 0;

                Bulletin::where('eleve_id', $eleve->id)
                    ->update(['moyenne_generale' => $moyenneGenerale]);
            });

        return back()->with('success', 'Moyennes annuelles calculées avec succès.');
    }

 public function exportRefusesPDF($anneeId, $classeId)
{
    // Récupérer le seuil depuis l’URL (ou 10 par défaut)
    $seuilAdmission = request()->query('seuil', 10);

    $classe = Classe::findOrFail($classeId);
    $annee = AnneeAcademique::findOrFail($anneeId);

    // Élèves refusés selon le seuil dynamique
    $eleves = Eleve::where('classe_id', $classeId)
        ->where('annee_academique_id', $anneeId)
        ->whereHas('bulletins', function ($q) use ($seuilAdmission) {
            $q->where('moyenne_generale', '<', $seuilAdmission);
        })
        ->with(['user', 'bulletins' => function ($q) {
            $q->latest('periode_id')->limit(1);
        }])
        ->get()
        ->each(function ($eleve) {
            $eleve->moyenne_generale = $eleve->bulletins->first()->moyenne_generale ?? 'N/A';
        });

    $pdf = Pdf::loadView('admin.migration.refuses_pdf', [
        'classe' => $classe,
        'annee' => $annee,
        'elevesRefuses' => $eleves,
        'seuilAdmission' => $seuilAdmission, // 🔸 Pour l'affichage dans le PDF
    ]);

    return $pdf->download("eleves_refuses_{$classe->nom}_{$annee->libelle}.pdf");
}

    public function exportAdmisPDF($anneeId, $classeId)
{
    $seuilAdmission = request()->query('seuil', 10);

    $classe = Classe::findOrFail($classeId);
    $annee = AnneeAcademique::findOrFail($anneeId);

    $eleves = Eleve::where('classe_id', $classeId)
        ->where('annee_academique_id', $anneeId)
        ->whereHas('bulletins', function ($q) use ($seuilAdmission) {
            $q->where('moyenne_generale', '>=', $seuilAdmission);
        })
        ->with(['user', 'bulletins' => function ($q) {
            $q->latest('periode_id')->limit(1);
        }])
        ->get()
        ->each(function ($eleve) {
            $eleve->moyenne_generale = $eleve->bulletins->first()->moyenne_generale ?? 'N/A';
        });

    $pdf = Pdf::loadView('admin.migration.admis_pdf', [
        'classe' => $classe,
        'annee' => $annee,
        'elevesAdmis' => $eleves,
        'seuilAdmission' => $seuilAdmission,
    ]);

    return $pdf->download("eleves_admis_{$classe->nom}_{$annee->libelle}.pdf");
}


    // Methode pour enregistrement des notes

    public function saisirNotes(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'periode_id' => 'required|exists:periodes_academiques,id',
            'annee_academique_id' => 'required|exists:annee_academique,id',
            'notes' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $coefficient = DB::table('classe_matiere_professeur')
                ->where('classe_id', $request->classe_id)
                ->where('matiere_id', $request->matiere_id)
                ->value('coefficient') ?? 1;

            foreach ($request->notes as $eleveId => $notes) {
                foreach ($notes as $type => $valeur) {
                    if ($valeur !== null && $valeur !== '' && is_numeric($valeur)) {
                        $valeur = floatval($valeur);
                        $typeEvaluation = strpos($type, 'interro') !== false ? 'interrogation' : 'devoir';

                        Note::updateOrCreate(
                            [
                                'eleve_id' => $eleveId,
                                'matiere_id' => $request->matiere_id,
                                'periode_id' => $request->periode_id,
                                'type_evaluation' => $typeEvaluation,
                                'nom_evaluation' => $type,
                            ],
                            [
                                'valeur' => $valeur,
                                'is_locked' => true,
                            ]
                        );
                    }
                }

                $notesEnregistrees = Note::where('eleve_id', $eleveId)
                    ->where('matiere_id', $request->matiere_id)
                    ->where('periode_id', $request->periode_id)
                    ->get();

                $interroNotes = $notesEnregistrees->where('type_evaluation', 'interrogation')->pluck('valeur')->all();
                $devoirNotes = $notesEnregistrees->where('type_evaluation', 'devoir')->pluck('valeur')->all();

                $interroCount = count($interroNotes);
                $devoirCount = count($devoirNotes);

                $interroMoy = $interroCount > 0 ? array_sum($interroNotes) / $interroCount : 0;
                $devoirMoy = $devoirCount > 0 ? array_sum($devoirNotes) : 0;

                if ($interroCount > 0 && $devoirCount > 0) {
                    $moyenne = ($interroMoy + $devoirMoy) / 3;
                } elseif ($interroCount > 0 && $devoirCount == 0) {
                    $moyenne = $interroMoy;
                } elseif ($interroCount == 0 && $devoirCount > 0) {
                    $moyenne = $devoirMoy;
                } else {
                    $moyenne = 0;
                }

                $moyenneCoefficient = $moyenne * $coefficient;

                Bulletin::updateOrCreate(
                    [
                        'eleve_id' => $eleveId,
                        'periode_id' => $request->periode_id,
                        'matiere_id' => $request->matiere_id,
                    ],
                    [
                        'total' => $moyenne,
                        'moyenne' => $moyenne,
                        'moyenne_coefficient' => $moyenneCoefficient,
                        'statut' => $moyenne >= 12 ? 1 : 0,
                        'rang' => 0,
                        'coefficient' => $coefficient,
                    ]
                );
            }

            $this->updateRanks($request->periode_id, $request->matiere_id);
            $this->calculatePeriodicAverages($request->periode_id, $request->classe_id);
            $this->calculatePeriodicRanks($request->periode_id, $request->classe_id);
            $this->calculerMoyenneAnnuelle($request->annee_academique_id, $request->classe_id);

        });

        return back()->with('success', 'Notes enregistrées avec succès!');
    }

    // Methode pour la mise a jour automatique des rangs

    private function updateRanks($periodeId, $matiereId)
    {
        $bulletins = Bulletin::where('periode_id', $periodeId)
            ->where('matiere_id', $matiereId)
            ->orderBy('moyenne', 'desc')
            ->get();

        $rank = 1;
        foreach ($bulletins as $bulletin) {
            $bulletin->update(['rang' => $rank]);
            $rank++;
        }
    }

    // Methode pour le calcule des moyenne par période

    private function calculatePeriodicAverages($periodeId, $classeId)
    {
        $eleves = Eleve::where('classe_id', $classeId)->get();

        foreach ($eleves as $eleve) {
            $results = DB::table('bulletins')
                ->join('classe_matiere_professeur', function ($join) use ($classeId) {
                    $join->on('bulletins.matiere_id', '=', 'classe_matiere_professeur.matiere_id')
                        ->where('classe_matiere_professeur.classe_id', '=', $classeId);
                })
                ->where('bulletins.eleve_id', $eleve->id)
                ->where('bulletins.periode_id', $periodeId)
                ->selectRaw('
                SUM(bulletins.moyenne * classe_matiere_professeur.coefficient) as total_moyenne_coeff,
                SUM(classe_matiere_professeur.coefficient) as total_coefficient
            ')
                ->first();

            if ($results && $results->total_coefficient > 0) {
                $moyennePeriodique = $results->total_moyenne_coeff / $results->total_coefficient;

                // Mettre à jour tous les bulletins de l'élève pour cette période
                Bulletin::where('eleve_id', $eleve->id)
                    ->where('periode_id', $periodeId)
                    ->update([
                        'moyenne_periodique' => $moyennePeriodique,
                    ]);
            }
        }
    }

    // Methode pour le calcule des rang par periode
    private function calculatePeriodicRanks($periodeId, $classeId)
    {
        $moyennes = Bulletin::where('periode_id', $periodeId)
            ->whereIn('eleve_id', function ($query) use ($classeId) {
                $query->select('id')
                    ->from('eleves')
                    ->where('classe_id', $classeId);
            })
            ->select('eleve_id', DB::raw('AVG(moyenne_periodique) as moyenne'))
            ->groupBy('eleve_id')
            ->orderByDesc('moyenne')
            ->get();

        $rang = 1;

        foreach ($moyennes as $item) {
            Bulletin::where('periode_id', $periodeId)
                ->where('eleve_id', $item->eleve_id)
                ->update([
                    'rang_periodique' => $rang,
                ]);
            $rang++;
        }
    }

    public function dashboar()
    {
        $classes = Classe::all();
        $annees = AnneeAcademique::all();

        return view('bulletin.index');
    }

    public function showBulletin()
    {
        $eleve = auth()->user();

        if (! $eleve instanceof \App\Models\Eleve) {
            abort(403, 'Accès non autorisé.');
        }

        $notes = Note::with('matieres')
            ->where('eleve_id', $eleve->id)
            ->get()
            ->groupBy('matiere.nom');

        $moyenneGenerale = $this->calculerMoyenneGenerale($notes);

        return view('bulletin.show', [
            'eleve' => $eleve,
            'notesParMatiere' => $notes,
            'moyenneGenerale' => $moyenneGenerale,
        ]);
    }

    private function calculerMoyenneGenerale($notesParMatiere)
    {
        $total = 0;
        $count = 0;

        foreach ($notesParMatiere as $matiere => $notes) {
            $moyenneMatiere = $notes->avg('valeur');
            $total += $moyenneMatiere;
            $count++;
        }

        return $count > 0 ? round($total / $count, 2) : 0;
    }

    // Gestion des statistiques

    public function showStatistics($anneeId, $classeId)
    {
        $professeurId = Auth::user()->professeur->id;

        // Récupérer les affectations du professeur
        $affectations = Affectation::where('professeur_id', $professeurId)
            ->where('classe_id', $classeId)
            ->where('annee_academique_id', $anneeId)
            ->with('matiere')
            ->get();

        $classe = Classe::findOrFail($classeId);
        $annee = AnneeAcademique::findOrFail($anneeId);
        $periodes = PeriodeAcademique::where('annee_academique_id', $anneeId)->get();

        // Récupérer la période sélectionnée (ou la première par défaut)
        $selectedPeriodeId = request('periode_id', $periodes->first()->id ?? null);
        $selectedMatiereId = request('matiere_id', $affectations->first()->matiere_id ?? null);

        $statistics = [];
        $topStudents = [];
        $bottomStudents = [];
        $successRates = [];
        $globalStats = null;

        if ($selectedPeriodeId) {
            // Statistiques par matière si une matière est sélectionnée
            if ($selectedMatiereId) {
                $statistics = $this->getMatiereStatistics($classeId, $selectedMatiereId, $selectedPeriodeId);
            }

            // Top 3 et 3 derniers élèves (toutes matières confondues)
            $topStudents = $this->getTopStudents($classeId, $selectedPeriodeId, 3);
            $bottomStudents = $this->getBottomStudents($classeId, $selectedPeriodeId, 3);

            // Taux de réussite global
            $globalStats = $this->getGlobalStatistics($classeId, $selectedPeriodeId);

            // Taux de réussite par matière
            foreach ($affectations as $affectation) {
                $successRates[$affectation->matiere->nom] = $this->getSuccessRate(
                    $classeId,
                    $affectation->matiere_id,
                    $selectedPeriodeId
                );
            }
        }

        return view('professeur.statistiques', compact(
            'classe',
            'annee',
            'periodes',
            'affectations',
            'selectedPeriodeId',
            'selectedMatiereId',
            'statistics',
            'topStudents',
            'bottomStudents',
            'globalStats',
            'successRates'
        ));
    }

    // Méthodes helper pour les statistiques
    private function getMatiereStatistics($classeId, $matiereId, $periodeId)
    {
        return Bulletin::where('matiere_id', $matiereId)
            ->where('periode_id', $periodeId)
            ->whereIn('eleve_id', function ($query) use ($classeId) {
                $query->select('id')
                    ->from('eleves')
                    ->where('classe_id', $classeId);
            })
            ->selectRaw('
            COUNT(*) as total_eleves,
            SUM(CASE WHEN statut = 1 THEN 1 ELSE 0 END) as reussite,
            SUM(CASE WHEN statut = 0 THEN 1 ELSE 0 END) as echec,
            AVG(moyenne) as moyenne_classe,
            MIN(moyenne) as pire_note,
            MAX(moyenne) as meilleure_note
        ')
            ->first();
    }

    private function getTopStudents($classeId, $periodeId, $limit = 3)
    {
        return Bulletin::with(['eleve.user'])
            ->where('periode_id', $periodeId)
            ->whereIn('eleve_id', function ($query) use ($classeId) {
                $query->select('id')
                    ->from('eleves')
                    ->where('classe_id', $classeId);
            })
            ->select('eleve_id', DB::raw('AVG(moyenne_periodique) as moyenne'))
            ->groupBy('eleve_id')
            ->orderByDesc('moyenne')
            ->limit($limit)
            ->get();
    }

    private function getBottomStudents($classeId, $periodeId, $limit = 3)
    {
        return Bulletin::with(['eleve.user'])
            ->where('periode_id', $periodeId)
            ->whereIn('eleve_id', function ($query) use ($classeId) {
                $query->select('id')
                    ->from('eleves')
                    ->where('classe_id', $classeId);
            })
            ->select('eleve_id', DB::raw('AVG(moyenne_periodique) as moyenne'))
            ->groupBy('eleve_id')
            ->orderBy('moyenne')
            ->limit($limit)
            ->get();
    }

    private function getGlobalStatistics($classeId, $periodeId)
    {
        return Bulletin::where('periode_id', $periodeId)
            ->whereIn('eleve_id', function ($query) use ($classeId) {
                $query->select('id')
                    ->from('eleves')
                    ->where('classe_id', $classeId);
            })
            ->selectRaw('
            COUNT(DISTINCT eleve_id) as total_eleves,
            AVG(moyenne_periodique) as moyenne_generale,
            SUM(CASE WHEN moyenne_periodique >= 12 THEN 1 ELSE 0 END) as reussite,
            SUM(CASE WHEN moyenne_periodique < 12 THEN 1 ELSE 0 END) as echec
        ')
            ->first();
    }

    private function getSuccessRate($classeId, $matiereId, $periodeId)
    {
        $stats = Bulletin::where('matiere_id', $matiereId)
            ->where('periode_id', $periodeId)
            ->whereIn('eleve_id', function ($query) use ($classeId) {
                $query->select('id')
                    ->from('eleves')
                    ->where('classe_id', $classeId);
            })
            ->selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN statut = 1 THEN 1 ELSE 0 END) as reussite
        ')
            ->first();

        return $stats->total > 0 ? round(($stats->reussite / $stats->total) * 100, 2) : 0;
    }
}
