<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $numbers = range(1, 5); // 1~5の配列
        shuffle($numbers); // 順番をランダムに並び替え

        $rand_num = mt_rand(0,4);// 0~4の数値をランダムに取得

        return [
            'shopname'    => $this->faker->company,
            'tags'        => implode(',', array_slice($numbers, $rand_num)),
            'deleted_flg' => $this->faker->boolean,
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
