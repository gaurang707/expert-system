<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoftDeleteUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Randomly select 10 non-deleted users
        $users = User::inRandomOrder()
            ->where('id', '!=', 1)
            ->limit(935)
            ->get();

        foreach ($users as $user) {
            $user->delete();
        }
    }
}
