<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::select('id')->get();
        $roles = Role::select('id')
            ->where('id', '!=', 1)
            ->get()->toArray();

        $roles_arr = Arr::pluck($roles, 'id');
        $roles_arr  = array_values($roles_arr);

        foreach ($users as $user) {

            if ($user->id == 1) {
                $user->roles()->sync([1]);
            } else {
                $randomTwo = Arr::random($roles_arr, 2);               
                $user->roles()->sync($randomTwo);
            }
        }
    }
}
