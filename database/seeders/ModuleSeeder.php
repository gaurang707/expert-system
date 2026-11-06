<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules =     [
                'users' => 'Users Management',
                'roles' => 'Roles Management',
                'modules' => 'Modules Management',
            ];

        foreach ($modules as $key => $value) {
            Module::firstOrCreate([
                'name' =>  $key,
                'description' => $value
            ]);
        }

        //modules permission
        $permissions = ['view', 'create', 'update', 'update'];

        $modules_all = Module::select('id', 'name')->get();
        foreach ($modules_all as $module) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'module_id' => $module->id,
                    'name' => $module->name.".".$permission,
                    'display_name' => $permission." ".$module->name
                ]);
            }
        }        

    }
}
