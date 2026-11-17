<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('roles/permissions', [RolePermissionController::class, 'index'])->name('role-permission');

    Route::post(
        '/roles/permissions',
        [RolePermissionController::class, 'update']
    )->name('roles.permissions.update');

    Route::get('admin/users/bulk-action', [UserController::class, 'bulkActionIndex'])->name('users.bulk.action');
    Route::post('admin/users/bulk-action', [UserController::class, 'bulkActionPost'])->name('users.bulk.action.post');

    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

Route::view('/jobs', 'jobs');

require __DIR__ . '/settings.php';
