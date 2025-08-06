<?php

namespace Database\Seeders;

use App\Models\ClasseMatiereProfesseur;
use Illuminate\Database\Seeder;

class ClasseMatiereProfesseurSeeder extends Seeder
{
    public function run()
    {
        // Supprimer les exixtantt
        ClasseMatiereProfesseur::truncate();

        ClasseMatiereProfesseur::create([
            'classe_id' => 1,
            'matiere_id' => 1,
            'professeur_id' => null,
            'coefficient' => 1
        ]);

        ClasseMatiereProfesseur::create([
            'classe_id' => 1,
            'matiere_id' => 2,
            'professeur_id' => null,
            'coefficient' => 1
        ]);

        ClasseMatiereProfesseur::create([
            'classe_id' => 2,
            'matiere_id' => 2,
            'professeur_id' => null,
            'coefficient' => 1
        ]);
    }
}
