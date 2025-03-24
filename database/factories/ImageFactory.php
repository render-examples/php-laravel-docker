<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $post_id = mt_rand(1,11);

        return [
            'image_url'   => "https://picsum.photos/200/300",
            'post_id'     => $post_id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
