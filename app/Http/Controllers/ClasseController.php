<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'niveau' => 'required|string|max:20',
            'serie' => 'nullable|string|max:50'
        ]);

        Classe::create($validated);

        return redirect()->route('classes.index')
                         ->with('success', 'Classe créée avec succès');
    }

      public function getMatieres(Classe $classe)
    {
        $matieres = Matiere::whereHas('classeMatiereProfesseur', function($query) use ($classe) {
            $query->where('classe_id', $classe->id)
                  ->whereNull('professeur_id');
        })->get(['id', 'nom', 'code']);

        return response()->json($matieres);
    }

}
