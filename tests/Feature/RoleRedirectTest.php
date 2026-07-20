<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleRedirectTest extends TestCase
{
    use RefreshDatabase; // 每次測試重建資料庫

    /** @test */
    public function user_is_redirected_to_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'user',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
    }
    
    /** @test */
    public function admin_is_redirected_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin/dashboard');
    }
}
