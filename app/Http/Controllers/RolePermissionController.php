<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RolePermissionController extends Controller
{
    public function index()
    {

        $totalRole = Role::count();
        $actionTotal = Action::count();
        $roles = Role::withCount('users')->with('permissions')->get();
        $countsByRole = Role::withCount('users')->pluck('users_count', 'name');
        $modules = Module::with('permissions')->get();
        $actions = [
            'view' => 'View',
            'create' => 'Create',
            'update' => 'Update',
            'delete' => 'Delete',
        ];
        return view(
            'inter.role-permission',
            compact('totalRole', 'actionTotal', 'roles', 'actions', 'countsByRole', 'modules')
        );
    }

    public function update(Request $request)
    {
        $actions = [
            'view',
            'create',
            'update',
            'delete',
        ];

        $allowedPermissions = [];

        $modules = Module::all();

        foreach ($modules as $module) {
            foreach ($actions as $action) {

                $permissionName = $module->slug . '.' . $action;

                $allowedPermissions[$permissionName] = $module->id;
            }
        }

        // 1. Validate submitted data
        // Validation errors automatically return to Blade's $errors.
        $validated = $request->validate([

            'role_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'role_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:roles,id',
            ],

            'permissions' => [
                'sometimes',
                'array',
            ],

            'permissions.*' => [
                'array',
            ],

            'permissions.*.*' => [
                'string',
                Rule::in(array_keys($allowedPermissions)),
            ],
        ]);

        $roles = Role::whereIn(
            'id',
            $validated['role_ids']
        )->get();

        // Important:
        // Authorize the current user to update permissions
        // for every submitted role using your policy or Gate.

        try {

            // 2. Save all role permissions in one transaction
            $result = DB::transaction(function () use (
                $roles,
                $validated,
                $allowedPermissions
            ) {

                $updatedRoles = 0;
                $totalSelectedPermissions = 0;

                foreach ($roles as $role) {

                    $selectedPermissions = array_unique(
                        $validated['permissions'][$role->id] ?? []
                    );

                    $permissionIds = [];

                    foreach ($selectedPermissions as $permissionName) {

                        $permission = Permission::firstOrCreate([
                            'module_id' => $allowedPermissions[$permissionName],
                            'name' => $permissionName,
                        ]);

                        $permissionIds[] = $permission->id;
                    }

                    $totalSelectedPermissions += count($permissionIds);

                    // sync() returns attached, detached and updated IDs
                    $changes = $role->permissions()->sync($permissionIds);

                    if (
                        !empty($changes['attached']) ||
                        !empty($changes['detached']) ||
                        !empty($changes['updated'])
                    ) {
                        $updatedRoles++;
                    }
                }

                return [
                    'updated_roles' => $updatedRoles,
                    'total_selected' => $totalSelectedPermissions,
                ];
            });

            // 3. INFO: Nothing changed
            if ($result['updated_roles'] === 0) {

                return back()->with(
                    'info',
                    'No permission changes were required. All role permissions are already up to date.'
                );
            }

            // 4. WARNING: All role permissions removed
            if ($result['total_selected'] === 0) {

                return back()
                    ->with(
                        'success',
                        'Role permission changes saved successfully.'
                    )
                    ->with(
                        'warning',
                        'All permissions have been removed from the submitted roles.'
                    );
            }

            // 5. SUCCESS: Permissions updated
            return back()->with(
                'success',
                $result['updated_roles'] .
                    ' role(s) permissions updated successfully.'
            );
        } catch (\Throwable $e) {

            // 6. Log the original exception for debugging
            report($e);

            // Return a safe message without exposing server details
            return back()->with(
                'error',
                'Unable to update role permissions. No changes were saved. Please try again.'
            );
        }
    }
}
