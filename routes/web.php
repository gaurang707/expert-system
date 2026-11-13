<?php

use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('roles/permissions', [RolePermissionController::class, 'index'])->name('role-permission');

    Route::post(
        '/roles/permissions',
        [RolePermissionController::class, 'update']
    )->name('roles.permissions.update');
});

Route::view('/jobs', 'jobs');

require __DIR__ . '/settings.php';
