<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($actions as $action) {
            Action::createOrFirst([
                'name'  => $action,
            ]);
        }
    }
}
