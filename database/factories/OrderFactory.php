<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::find(1),
            'order_number' => 'ORD-' . strtoupper(fake()->unique()->bothify('########')),
            'status' => 'pending',
            'total_amount' => mt_rand(100, 10000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
