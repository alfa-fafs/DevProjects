<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CreateRideTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_ride(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Act as that user and send request
        $response = $this->actingAs($user, 'sanctum')->postJson('/api/rides', [
            'pickup_location' => 'East Legon',
            'dropoff_location' => 'Airport',
            'pickup_lat' => 5.6037,
            'pickup_lng' => -0.1870,
            'dropoff_lat' => 5.6050,
            'dropoff_lng' => -0.1670,
        ]);

        // Assert status
        $response->assertStatus(201);

        // Assert database has ride
        $this->assertDatabaseHas('rides', [
            'pickup_location' => 'East Legon',
            'dropoff_location' => 'Airport',
            'user_id' => $user->id,
        ]);
    }
}
