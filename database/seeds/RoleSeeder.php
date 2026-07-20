<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => '主管']);
        $employee = Role::create(['name' => '一般員工']);

        $approveOrder = Permission::where('name', 'approve_order')->first();
        $viewReport = Permission::where('name', 'view_report')->first();

        // 關聯用法 
        // Laravel 會自動推斷 pivot table 名稱， 規則：按字母排序 + 下底線
        $admin->permissions()->attach([$approveOrder->id, $viewReport->id]);
    }
}
