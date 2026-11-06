<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'admin' => 'Admin',
            'manager' => 'Manager',
            'editor' => 'Editor',
            'user' => 'User'
        ];

        foreach ($roles as $key => $value) {
            Role::firstOrCreate([
                'name' => $key
            ]);
        }

        $roleIds = Role::pluck('id')->all(); //get all role Ids

        if (empty($roleIds)) {
            throw new \RuntimeException('No roles found.');
        }

        $userIds = User::pluck('id')->all(); //get all user Ids

        User::chunkById(100, function ($users) use ($roleIds) {
            foreach ($users as $user) {

                if ($user->id === 1) {
                    $user->roles()->sync([1]);
                } else {
                    $randomRoleIds = fake()->randomElements(
                        $roleIds,
                        min(2, count($roleIds))
                    );

                    $user->roles()->sync($randomRoleIds);
                }
            }
        });
    }
}
