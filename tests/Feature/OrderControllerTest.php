<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderSuccess()
    {
        $data = [
            'id' => 'A0000001',
            'name' => 'Test Order',
            'address' => [
                'city' => 'Test City',
                'district' => 'Test District',
                'street' => 'Test Street',
            ],
            'price' => '1050',
            'currency' => 'TWD',
        ];

        $this->postJson('/api/orders', $data)->assertStatus(200)
            ->assertJson([
                'message' => 'Order processed successfully',
            ]);
    }

    public function testOrderFailure()
    {
        $data = [
            'id' => 'A0000001',
            'name' => '',
            'address' => [
                'city' => 'Test City',
                'district' => 'Test District',
                'street' => 'Test Street',
            ],
            'price' => '2050',
            'currency' => 'TWD',
        ];

        $response = $this->postJson('/api/orders', $data);

        $response->assertJsonValidationErrors(['name', 'price']);
    }
}
