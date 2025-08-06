<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;

class MatieresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Matiere::create([
            'nom' => 'Maths',
            'code' => 'MT',
        ]);

        Matiere::create([
            'nom' => 'Français',
            'code' => 'FA',
        ]);

        Matiere::create([
            'nom' => 'Physique',
            'code' => 'PH',
        ]);

        Matiere::create([
            'nom' => 'Anglais',
            'code' => 'AG',
        ]);

        Matiere::create([
            'nom' => 'Sport',
            'code' => 'EPS',
        ]);
    }
}
