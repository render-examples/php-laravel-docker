<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'       => '最初のユーザ',
                'email'      => 'aaa@aaa.com',
                'password'   => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => '二番目のユーザ',
                'email'      => 'bbb@bbb.com',
                'password'   => Hash::make('password456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => '三番目のユーザ',
                'email'      => 'ccc@ccc.com',
                'password'   => Hash::make('password789'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
