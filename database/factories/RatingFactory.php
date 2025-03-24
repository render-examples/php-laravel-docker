<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rating>
 */
class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id'     => null,
            'post_id'     => null,
            'rating'      => $this->faker->numberBetween(1, 5),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
