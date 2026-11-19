<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Order::factory(50)->create();

        // User::factory()->create([
        //     'name' => 'GP',
        //     'email' => 'gargpind@gmail.com',
        // ]);

        //User::factory(2000)->create();

        // $this->call([
        //     RoleSeeder::class,
        //     UserRoleSeeder::class,
        //     //ActionSeeder::class
        // ]);
    }
}
