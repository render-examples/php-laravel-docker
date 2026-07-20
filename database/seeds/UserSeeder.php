<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'name' => '主管小明',
            'email' => 'adminMin@test.com',
            'password' => Hash::make('password123')
        ]);

        $employeeUser = User::create([
            'name' => '一般員工小華',
            'email' => 'employeeHau@test.com',
            'password' => Hash::make('password123')
        ]);

        // 指定角色
        $admin = Role::where('name', '主管')->first();
        $employee = Role::where('name', '一般員工')->first();
        
        // 關聯用法 
        // Laravel 會自動推斷 pivot table 名稱， 規則：按字母排序 + 下底線
        $adminUser->roles()->attach($admin->id);
        $employeeUser->roles()->attach($employee->id);
    }
}
