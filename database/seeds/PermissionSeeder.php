<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'approve_order', 'description' => '審核訂單'],
            ['name' => 'view_report', 'description' => '查看報表'],
        ];

        // firstOrCreate() 需要 兩個參數：
        // 第一個是「搜尋條件」，找不到才新增
        // 第二個是「額外欄位資料」
        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(
                ['name' => $permissionData['name']], // 搜尋條件
                ['description' => $permissionData['description']] // 其他欄位
            );
            
        }
    }
}
