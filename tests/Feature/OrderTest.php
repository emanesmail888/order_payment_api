<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\User;

class OrderTest extends TestCase
{
   public function test_pay_order_successfully()
    {
        // Create a user
        $user = User::factory()->create(['points' => 0]);

        // Create an order for the user
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'total_price' => 100.00,
            'status' => 'pending',
        ]);

        // Send POST request to the pay endpoint
        $response = $this->postJson("/api/orders/{$order->id}/pay", ['orderId' => $order->id]);

        // Assert the response
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'user_points' => 110, // 100 (total_price) + 10 (bonus for >= 100)
                     'order' => [
                         'id' => $order->id,
                         'status' => 'paid',
                     ],
                 ]);

        // Verify the database state
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'points' => 110,
        ]);
    }
}
