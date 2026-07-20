<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $products = [
            ['name' => '筆記型電腦', 'price' => 28900],
            ['name' => '桌上型電腦', 'price' => 35900],
            ['name' => '24吋液晶螢幕', 'price' => 5990],
            ['name' => '無線滑鼠', 'price' => 790],
            ['name' => '機械式鍵盤', 'price' => 2490],
            ['name' => '雷射印表機', 'price' => 8990],
            ['name' => '多功能事務機', 'price' => 12900],
            ['name' => '網路交換器 24 Port', 'price' => 6500],
            ['name' => '無線基地台', 'price' => 3200],
            ['name' => 'NAS 儲存設備', 'price' => 25900],
            ['name' => '辦公椅', 'price' => 4500],
            ['name' => '辦公桌', 'price' => 6800],
            ['name' => 'A4 影印紙', 'price' => 150],
            ['name' => '碳粉匣', 'price' => 3200],
            ['name' => '條碼掃描器', 'price' => 2900],
            ['name' => '工業用平板電腦', 'price' => 18500],
            ['name' => 'PLC 控制器', 'price' => 42000],
            ['name' => '變頻器', 'price' => 9800],
            ['name' => '感測器模組', 'price' => 1200],
            ['name' => '工業電源供應器', 'price' => 3500],
        ];

        $product = fake()->randomElement($products);
        return [
            'name' => $product['name'],
            'price' => $product['price'],
            'description' => fake('zh_TW')->sentence(),
        ];
    }
}
