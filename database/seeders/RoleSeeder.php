<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //role seeder 
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'administrator'
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin'
            ],
            [
                'name' => 'Editor',
                'slug' => 'editor'
            ],
            [
                'name' => 'Subscriber',
                'slug' => 'subscriber'
            ],
            [
                'name' => 'Author',
                'slug' => 'author'
            ],
            [
                'name' => 'Contributor',
                'slug' => 'contributor'
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                $role
            );
        }


        // modules seeder
        $modules = [
            [
                'name' => 'Role Management',
                'slug' => 'roles'
            ],
            [
                'name' => 'User Management',
                'slug' => 'users'
            ],
            [
                'name' => 'Module Management',
                'slug' => 'modules'
            ],
            [
                'name' => 'Content Management',
                'slug' => 'contents'
            ],
        ];

        foreach ($modules as $module) {
            Module::firstOrCreate(
                $module
            );
        }
    }
}
