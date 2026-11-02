<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $password = Hash::make('Password');

        User::firstOrCreate(
            ['email' => 'gargpind@gmail.com'],
            [
                'name' => 'GP',
                'password' => $password,
                'email_verified_at' => now(),
            ],
        );

        $roles = Role::whereIn('name', [
            'admin', 'administrator', 'editor', 'author', 'manager', 'subscriber',
        ])->get();

        foreach ($roles as $role) {
            User::firstOrCreate(
                ['email' => "{$role->name}@example.com"],
                [
                    'name' => ucfirst($role->name).' User',
                    'role_id' => $role->id,
                    'password' => $password,
                    'email_verified_at' => now(),
                ],
            );
        }
        
    }
}
