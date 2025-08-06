<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nom' => 'Martiace',
            'prenom' => 'Martiace',
            'telephone' => '0100000000',
            'photo' => 'url.jpg',
            'email' => 'admin@gmail.com',
            'date_de_naissance' => '1990-01-01',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'is_active' => true,
        ]);
    }
}
