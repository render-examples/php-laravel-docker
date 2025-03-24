<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\PostDetail>
 */
class PostDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address'     => $this->faker->address,
            'post_id'     => null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
