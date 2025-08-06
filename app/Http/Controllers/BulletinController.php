<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Note;
use App\Models\Eleve;
use App\Models\Bulletin;
use App\Models\AnneeAcademique;
use App\Models\PeriodeAcademique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BulletinController extends Controller
{
    public function index()
    {
        $eleve = auth()->user()->eleve;

        // Récupération des périodes via les notes de l’élève
        $periodeIds = Note::where('eleve_id', $eleve->id)
            ->pluck('periode_id')
            ->unique()
            ->filter();

        // Récupération des années académiques via les périodes
        $anneeIds = PeriodeAcademique::whereIn('id', $periodeIds)
            ->pluck('annee_academique_id')
            ->unique()
            ->filter();

        $annees = AnneeAcademique::whereIn('id', $anneeIds)->get();

        return view('bulletin.index', compact('annees', 'eleve'));
    }

    public function show($annee_academique_id)
    {
        $eleve = auth()->user()->eleve;
         $annee = \App\Models\AnneeAcademique::find($annee_academique_id);
        // On récupère les bulletins uniquement pour l’année demandée via la relation avec période
        $bulletins = Bulletin::where('eleve_id', $eleve->id)
            ->whereHas('periode', function ($query) use ($annee_academique_id) {
                $query->where('annee_academique_id', $annee_academique_id);
            })
            ->with(['periode', 'matiere'])
            ->get();

        $notes = [];

        foreach ($bulletins as $bulletin) {
            foreach (['interro1', 'interro2', 'interro3', 'devoir1', 'devoir2'] as $type) {
                $note = Note::where('eleve_id', $eleve->id)
                    ->where('periode_id', $bulletin->periode_id)
                    ->where('matiere_id', $bulletin->matiere_id)
                    ->where('type_evaluation', Str::startsWith($type, 'interro') ? 'interrogation' : 'devoir')
                    ->where('nom_evaluation', $type)
                    ->first();

                $notes[$bulletin->periode_id][$bulletin->matiere_id][$type] = $note;
            }
        }

        return view('bulletin.bulletin', compact('bulletins', 'notes', 'eleve'),[
            'annee' => $annee,
        ]);
    }


   public function editUser(User $user)
    {
        return view('admin.users.editeleve', compact('user'));
    }

public function downloadBulletin($annee_academique_id)
{
    $eleve = auth()->user()->eleve;
    $annee = AnneeAcademique::find($annee_academique_id);

    // Récupérer les bulletins avec les relations
    $bulletins = Bulletin::where('eleve_id', $eleve->id)
        ->whereHas('periode', function($query) use ($annee_academique_id) {
            $query->where('annee_academique_id', $annee_academique_id);
        })
        ->with(['periode', 'matiere'])
        ->get();

    // Récupérer l'effectif de la classe
    $effectifClasse = Eleve::where('classe_id', $eleve->classe_id)->count();

    // Initialiser les variables
    $notes = [];
    $moyennesPeriodes = [];
    $totalPeriodes = 0;
    $sommeMoyennesPeriodes = 0;

    foreach ($bulletins as $bulletin) {
        $periodeId = $bulletin->periode_id;
        $matiereId = $bulletin->matiere_id;

        // Récupérer les notes
        $notesMatiere = Note::where('eleve_id', $eleve->id)
            ->where('periode_id', $periodeId)
            ->where('matiere_id', $matiereId)
            ->get();

        // Organiser les notes par type
        $interros = $notesMatiere->where('type_evaluation', 'interrogation');
        $devoirs = $notesMatiere->where('type_evaluation', 'devoir');

        // Calcul des moyennes
        $moyInterros = $interros->avg('valeur');
        $moyDevoirs = $devoirs->avg('valeur');
        $coefficient = $bulletin->matiere->coefficient ?? 1;

        // Calcul de la moyenne selon la formule : (moyInterros + devoir1 + devoir2) / 3
        $devoir1 = $devoirs->where('nom_evaluation', 'devoir1')->first()->valeur ?? 0;
        $devoir2 = $devoirs->where('nom_evaluation', 'devoir2')->first()->valeur ?? 0;
        $moyenne = ($moyInterros + $devoir1 + $devoir2) / 3;
        $moyenneCoeff = $moyenne * $coefficient;

        // Stocker les notes pour l'affichage
        $notes[$periodeId][$matiereId] = [
            'interro1' => $interros->where('nom_evaluation', 'interro1')->first()->valeur ?? null,
            'interro2' => $interros->where('nom_evaluation', 'interro2')->first()->valeur ?? null,
            'interro3' => $interros->where('nom_evaluation', 'interro3')->first()->valeur ?? null,
            'devoir1' => $devoir1,
            'devoir2' => $devoir2,
            'moy_interros' => $moyInterros,
            'moy_devoirs' => $moyDevoirs,
            'moyenne' => $moyenne,
            'coefficient' => $coefficient,
            'moyenne_coeff' => $moyenneCoeff
        ];

        // Calcul pour la moyenne annuelle
        if (!isset($moyennesPeriodes[$periodeId]['total_coeff'])) {
            $moyennesPeriodes[$periodeId] = [
                'total_coeff' => 0,
                'total_moy_coeff' => 0
            ];
        }

        $moyennesPeriodes[$periodeId]['total_coeff'] += $coefficient;
        $moyennesPeriodes[$periodeId]['total_moy_coeff'] += $moyenneCoeff;
    }

    // Calcul des moyennes par période et moyenne annuelle
    $moyennesCalculPeriodes = [];
    foreach ($moyennesPeriodes as $periodeId => $data) {
        $moyennesCalculPeriodes[$periodeId] = $data['total_moy_coeff'] / $data['total_coeff'];
        $sommeMoyennesPeriodes += $moyennesCalculPeriodes[$periodeId];
        $totalPeriodes++;
    }

    $moyenneAnnuelle = $totalPeriodes > 0 ? $sommeMoyennesPeriodes / $totalPeriodes : 0;

    // Calcul du rang annuel (approximation)
    $rangAnnuel = Bulletin::where('eleve_id', $eleve->id)
        ->whereHas('periode', function($query) use ($annee_academique_id) {
            $query->where('annee_academique_id', $annee_academique_id);
        })
        ->avg('rang_periodique');

    $pdf = Pdf::loadView('bulletin.pdf', [
        'eleve' => $eleve,
        'annee' => $annee,
        'bulletins' => $bulletins,
        'notes' => $notes,
        'rangAnnuel' => round($rangAnnuel),
        'moyenneAnnuelle' => round($moyenneAnnuelle, 2),
        'effectifClasse' => $effectifClasse,
        'groupes' => $bulletins->groupBy('periode_id')
    ]);

    return $pdf->download("bulletin_{$eleve->user->nom}_{$annee->libelle}.pdf");
}
      public function editProfileleve()
    {
        $user = Auth::user();

        return view('profile.editeleve', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'telephone' => 'nullable|string|max:20',
            'date_de_naissance' => 'nullable|date',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('telephone')) {
            $user->telephone = $request->telephone;
        }

        if ($request->filled('date_de_naissance')) {
            $user->date_de_naissance = $request->date_de_naissance;
        }

        return $count > 0 ? round($total / $count, 2) : 0;

        $user->save();

        return redirect()->back()->with('success', 'Profil mis à jour avec succès.');
    }
}
