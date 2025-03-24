<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rating;
use Faker\Factory as Faker;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $usedPairs = [];
        $users = range(1,3);
        $posts = range(1,11);

        for ($i = 0; $i < 32; $i++) {
            do {
                $userId = $faker->randomElement($users);
                $postId = $faker->randomElement($posts);
            } while (in_array([$userId, $postId], $usedPairs));
            
            // ユニークなペアを追加
            $usedPairs[] = [$userId, $postId];
            
            Rating::factory()->create([
                'user_id' => $userId,
                'post_id' => $postId
            ]);
        }
    }
}
