<?php

use App\Models\PostDetail;
use Database\Seeders\ImageSeeder;
use Database\Seeders\PostDetailSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\RatingSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RatingSeeder::class);
        $this->call(PostDetailSeeder::class);
    }
}
