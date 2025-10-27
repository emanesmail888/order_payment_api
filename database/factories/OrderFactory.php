<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Creates a user or references an existing one
            'total_price' => $this->faker->randomFloat(2, 10, 1000), // Random price between 10.00 and 1000.00
            'status' => $this->faker->randomElement(['pending', 'paid', 'cancelled']), // Random status
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
