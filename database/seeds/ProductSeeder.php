<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 呼叫 factory 產生 10 筆資料，每筆都有 amount
        Product::factory()->count(10)->create();
    }
}
