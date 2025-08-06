<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            AdministrationSeeder::class,
            ClassesSeeder::class,
            MatieresSeeder::class,
            ClasseMatiereProfesseurSeeder::class,
        ]);
    }
}
