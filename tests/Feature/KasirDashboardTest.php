<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_kasir_dashboard_route_renders_cashier_page_without_redirecting_to_admin()
    {
        $user = User::query()->create([
            'name' => 'Kasir Test',
            'username' => 'kasir-test',
            'password' => bcrypt('password'),
        ]);

        Role::query()->create([
            'user_id' => $user->id,
            'role' => 'Kasir',
        ]);

        $response = $this->actingAs($user)->get(route('kasir.dashboard'));

        $response->assertOk();
        $response->assertViewIs('kasir.kasir');
    }
}