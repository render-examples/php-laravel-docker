<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                '台灣積體電路製造股份有限公司',
                '聯發科技股份有限公司',
                '統一企業股份有限公司',
                '長榮海運股份有限公司',
                '大山電線電纜股份有限公司',
                '台達電子工業股份有限公司',
                '宏碁股份有限公司',
                '華碩電腦股份有限公司',
                '和碩聯合科技股份有限公司',
                '中鋼股份有限公司',
                '奇美實業股份有限公司',
                '遠東新世紀股份有限公司',
                '南亞塑膠工業股份有限公司',
                '台塑企業股份有限公司',
                '中華電信股份有限公司',
                '全聯實業股份有限公司',
                '家樂福股份有限公司',
                '統一超商股份有限公司',
                '玉山商業銀行股份有限公司',
                '嘉義食品工業股份有限公司',
            ]),
            'phone' => '09' . fake()->numerify('########'),
            'tax_id_number' => fake()->numerify('########'),
            'address' =>
                fake()->randomElement(['台北市', '新北市', '桃園市', '台中市', '台南市', '高雄市']) .
                fake()->randomElement(['中正區', '東區', '西區', '北區', '南區']) .
                fake()->randomElement(['中山路', '民生路', '自由路', '文化路', '成功路', '中正路']) .
                fake()->numberBetween(1, 500) . '號',
        ];
    }
}
