<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed 50 sample products.
     */
    public function run(): void
    {
        $types = [
            'Headphones', 'Keyboard', 'Mouse', 'Monitor', 'Speaker',
            'Webcam', 'Microphone', 'Laptop Stand', 'USB Hub', 'Charger',
        ];

        foreach (['Essential', 'Classic', 'Pro', 'Premium', 'Elite'] as $range) {
            foreach ($types as $type) {
                Product::updateOrCreate(
                    ['name' => "{$range} {$type}"],
                    [
                        'description' => fake()->paragraph(),
                        'price' => fake()->randomFloat(2, 10, 1000),
                    ],
                );
            }
        }
    }
}
