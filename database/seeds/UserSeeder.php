<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => "test1",
            'email' => "test@test.test1",
            'password' => Hash::make('testtest'),
        ]);
        DB::table('users')->insert([
            'name' => "test2",
            'email' => "test@test.test2",
            'password' => Hash::make('testtest'),
        ]);
        DB::table('users')->insert([
            'name' => "test3",
            'email' => "test@test.test3",
            'password' => Hash::make('testtest'),
        ]);
        DB::table('users')->insert([
            'name' => "test4",
            'email' => "test@test.test4",
            'password' => Hash::make('testtest'),
        ]);
    }
}
