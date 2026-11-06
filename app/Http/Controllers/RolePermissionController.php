<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index() 
    {
        $totalRoles = Role::where('status', true)->count();
        $permissions = 0; 
        $assignedUsers = 0;
        $roles = Role::where('status', true)->get();
        $modules = Module::get();
        $actions = Action::get();
        

        return view('intern.permission.assign-permission', compact(
            'totalRoles',
            'permissions',
            'assignedUsers',
            'roles',
            'modules',
            'actions'

        ));
    }
}
