<?php

namespace Database\Seeders;

use App\Models\PostDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostDetail::factory()
        ->count(11)
        ->sequence(fn ($sequence) => ['post_id' => $sequence->index + 1])
        ->create();
    }
}
