<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class VendorTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateVendor()
    {
        $user = User::factory()->create();

        // Authenticate the user using Sanctum
        Sanctum::actingAs($user);

        // Data for creating a vendor
        $data = [
            'name' => 'Test Vendor',
            'description' => 'Sample vendor for testing',
        ];

        // Send a POST request to the vendor creation endpoint
        $response = $this->json('POST', '/api/vendors', $data);

        // Assertions
        $response->assertStatus(201); // Expecting a successful creation status
        $this->assertDatabaseHas('vendors', ['name' => 'Test Vendor']);
    }
}
