<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\AnneeAcademique;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\PeriodeAcademique;
use App\Models\Professeur;
use App\Models\Reclamation;
use App\Models\User;
use App\Notifications\AdminReclamationNotification;
use App\Notifications\ReclamationResponseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReclamationController extends Controller
{
    public function create(Eleve $eleve)
    {
        $professeur = Auth::user()->professeur;

        if (! $professeur) {
            abort(403, 'Accès réservé aux professeurs');
        }

        // Récupérer les matières enseignées par ce professeur pour cet élève
        $matieres = Matiere::whereHas('affectations', function ($query) use ($professeur, $eleve) {
            $query->where('professeur_id', $professeur->id)
                ->where('classe_id', $eleve->classe_id);
        })->get();

        $periodes = PeriodeAcademique::where('annee_academique_id', $eleve->annee_academique_id)->get();
        $annee = AnneeAcademique::find($eleve->annee_academique_id);

        return view('professeur.reclamations.create', compact('eleve', 'matieres', 'periodes', 'annee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'periode_id' => 'required|exists:periodes_academiques,id',
            'type_evaluation' => 'required|string|in:interro1,interro2,interro3,devoir1,devoir2',
            'description' => 'required|string|min:10',
        ]);

        try {
            DB::beginTransaction();

            $professeur = Auth::user()->professeur;
            if (! $professeur) {
                abort(403, 'Accès réservé aux professeurs');
            }

            $eleve = Eleve::findOrFail($request->eleve_id);

            // Vérification que le professeur enseigne bien la matière à l'élève
            $affectation = Affectation::where('professeur_id', $professeur->id)
                ->where('matiere_id', $request->matiere_id)
                ->where('classe_id', $eleve->classe_id)
                ->first();

            if (! $affectation) {
                abort(403, 'Vous n\'enseignez pas cette matière à cet élève');
            }

            $typeEvaluationRaw = $request->type_evaluation;
            $typeMapped = str_starts_with($typeEvaluationRaw, 'interro') ? 'interrogation' : 'devoir';

            // Chercher la note existante
            $note = Note::where('eleve_id', $eleve->id)
                ->where('matiere_id', $request->matiere_id)
                ->where('periode_id', $request->periode_id)
                ->where('type_evaluation', $typeMapped)
                ->where('nom_evaluation', $typeEvaluationRaw)
                ->first();

            if (! $note) {
                $note = Note::create([
                    'eleve_id' => $eleve->id,
                    'matiere_id' => $request->matiere_id,
                    'periode_id' => $request->periode_id,
                    'valeur' => 0,
                    'type_evaluation' => $typeMapped,
                    'nom_evaluation' => $typeEvaluationRaw,
                    'is_locked' => true,
                ]);
            }

            // Vérifier qu'une réclamation similaire n'existe pas déjà
            $existingReclamation = Reclamation::where('eleve_id', $eleve->id)
                ->where('matiere_id', $request->matiere_id)
                ->where('periode_id', $request->periode_id)
                ->where('annee_academique_id', $eleve->annee_academique_id)
                ->where('note_id', $note->id)
                ->where('type_evaluation', $typeMapped)
                ->where('type', 'modification_note')
                ->whereIn('statut', ['nouvelle_admin', 'nouvelle', 'resolue'])
                ->first();

            if ($existingReclamation) {
                DB::rollBack();

                return redirect()->route('reclamations.create', ['eleve' => $eleve->id])
                    ->withErrors(['error' => 'Une réclamation similaire existe déjà pour cette note.'])
                    ->withInput();
            }

            // Créer la réclamation avec une valeur NULL pour 'bulletin_id' si nécessaire
            $reclamation = Reclamation::create([
                'matiere_id' => $request->matiere_id,
                'type_evaluation' => $typeMapped,
                'periode_id' => $request->periode_id,
                'annee_academique_id' => $eleve->annee_academique_id,
                'type' => 'modification_note',
                'description' => $request->description,
                'statut' => 'nouvelle_admin',
                'eleve_id' => $eleve->id,
                'note_id' => $note->id,
                'professeur_id' => $professeur->id,
                'bulletin_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (! $reclamation) {
                DB::rollBack();

                return redirect()->route('reclamations.create', ['eleve' => $eleve->id])
                    ->withErrors(['error' => 'La création de la réclamation a échoué.'])
                    ->withInput();
            }

            // Notification admin
            $admin = User::where('is_admin', 1)->first();
            if ($admin) {
                $admin->notify(new AdminReclamationNotification($reclamation));
            }

            DB::commit();

            return redirect()->route('reclamations.create', ['eleve' => $eleve->id])
                ->with('success', 'Réclamation envoyée à l\'administration avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur création réclamation: '.$e->getMessage());

            return redirect()->route('reclamations.create', ['eleve' => $eleve->id])
                ->withErrors(['error' => 'Une erreur est survenue: '.$e->getMessage()])
                ->withInput();
        }
    }

    public function professeurIndex()
    {
        $professeur = Auth::user()->professeur;

        if (! $professeur) {
            abort(403, 'Accès réservé aux professeurs');
        }

        $reclamations = Reclamation::where('professeur_id', $professeur->id)
            ->with(['eleve.user', 'matiere', 'periode', 'note'])
            ->latest()
            ->paginate(10);

        return view('professeur.reclamations.create', compact('reclamations'));
    }

    public function suiviReclamations($eleve_id = null)
    {
        $professeur = Auth::user()->professeur;

        if (! $professeur) {
            abort(403, 'Accès réservé aux professeurs');
        }

        $query = Reclamation::where('professeur_id', $professeur->id)
            ->with(['eleve.user', 'matiere', 'periode', 'note'])
            ->latest();

        // Si un ID d'élève est fourni
        if ($eleve_id) {
            $query->where('eleve_id', $eleve_id);
        }

        // Récupérer les réclamations
        $reclamations = $query->get();

        // Récupérer la liste des élèves
        $eleves = Eleve::where('classe_id', $professeur->classe_id)->get();

        return view('professeur.reclamations.suivi', compact('reclamations', 'eleves'));
    }

    public function adminIndex()
    {
        $reclamations = Reclamation::where('statut', 'nouvelle_admin')
            ->with(['eleve.user', 'matiere', 'periode', 'note', 'professeur.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.reclamations.index', compact('reclamations'));
    }

    public function unlockNote(Request $request, Reclamation $reclamation)
    {
        $validated = $request->validate([
            'action' => 'required|in:accept,reject',
            'reponse_admin' => 'required_if:action,reject|nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($validated, $reclamation) {
            $note = $reclamation->note;

            if ($validated['action'] === 'accept') {
                // Déverrouiller la note
                if ($note && $note->is_locked) {
                    $note->update(['is_locked' => false]);
                }
            } elseif ($validated['action'] === 'reject') {
                // Rejeter, verrouiller la note si elle ne l'est pas déjà
                if ($note && ! $note->is_locked) {
                    $note->update(['is_locked' => true]);
                }
            }

            // Mettre à jour la réclamation
            $reclamation->update([
                'statut' => $validated['action'] === 'accept' ? 'resolue' : 'rejetee',
                'reponse_admin' => $validated['reponse_admin'] ?? ($validated['action'] === 'accept' ? 'Note déverrouillée' : 'Note verrouillée'),
            ]);

            // Notification au professeur
            if ($reclamation->professeur && $reclamation->professeur->user) {
                $reclamation->professeur->user->notify(new ReclamationResponseNotification($reclamation));
            }
        });

        return back()->with('success', 'Réclamation traitée avec succès.');
    }
}
