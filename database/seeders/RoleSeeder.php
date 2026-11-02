<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'administrator', 'editor', 'author', 'manager', 'subscriber'] as $name) {
            Role::firstOrCreate(
                ['name' => $name],
                ['display_name' => ucfirst($name), 'status' => true],
            );
        }
    }
}
