<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_available_stock_report(): void
    {
        $response = $this->get('/reports/available-stock');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_usage_report(): void
    {
        $response = $this->get('/reports/usage');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_available_stock_report(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/reports/available-stock');

        $response->assertOk();
    }

    public function test_authenticated_user_can_access_usage_report(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/reports/usage');

        $response->assertOk();
    }
}