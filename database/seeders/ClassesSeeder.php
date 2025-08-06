<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classe::create([
            'nom' => 'Classe A',
            'serie' => 'D',
        ]);

        Classe::create([
            'nom' => 'Classe B',
            'serie' => 'AB',
        ]);

        Classe::create([
            'nom' => 'Classe C',
            'serie' => '',
        ]);

        Classe::create([
            'nom' => 'Classe D',
            'serie' => '',
        ]);

        Classe::create([
            'nom' => 'Classe E',
            'serie' => '',
        ]);
    }
}
