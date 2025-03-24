<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            [
                'name' => '中華',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '和食',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'イタリアン',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '洋食',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '居酒屋',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'フレンチ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '韓国料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'アジア料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '焼肉',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'カレー',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
