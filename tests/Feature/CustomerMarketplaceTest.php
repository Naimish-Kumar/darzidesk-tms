<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerMarketplaceTest extends TestCase
{
    /** @test */
    public function public_marketplace_returns_tailor_shops()
    {
        $response = $this->getJson('/api/marketplace/shops');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => [
                    'featured_tailors',
                    'nearby_tailors',
                    'best_rated_tailors',
                    'all_shops',
                    'categories',
                ]
            ]);
    }

    /** @test */
    public function customer_can_self_register()
    {
        $payload = [
            'name' => 'Jane Customer',
            'email' => 'jane_' . time() . '@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone_number' => '+919999888777',
            'city' => 'Mumbai',
            'device_name' => 'test_device',
        ];

        $response = $this->postJson('/api/register/customer', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'token',
                'user' => ['id', 'name', 'email', 'type']
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
            'type' => 'customer',
        ]);
    }
}
