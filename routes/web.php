<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserImportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::get('roles/permissions', [RolePermissionController::class, 'index'])->name('role-permission');

    Route::post(
        '/roles/permissions',
        [RolePermissionController::class, 'update']
    )->name('roles.permissions.update');

    Route::get('admin/users/bulk-action', [UserController::class, 'bulkActionIndex'])->name('users.bulk.action');
    Route::post('admin/users/bulk-action', [UserController::class, 'bulkActionPost'])->name('users.bulk.action.post');

    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('admin/notification', [NotificationController::class, 'index'])->name('admin.notifications.index');

    Route::patch('admin/notifications/mark-all-read', [
        NotificationController::class,
        'markAllRead'
    ])->name('admin.notifications.mark-all-read');

    Route::patch('admin/notifications/{id}/toggle-read', [
        NotificationController::class,
        'toggleRead'
    ])->name('admin.notifications.toggle-read');

    Route::delete('admin/notifications/{id}', [
        NotificationController::class,
        'destroy'
    ])->name('admin.notifications.destroy');

    Route::get('admin/importcsv', [UserImportController::class, 'index'])->name('importcsv.index');
    Route::post('admin/importcsv', [UserImportController::class, 'store'])->name('importcsv.store');

    Route::get('admin/importcsvqueue', [UserImportController::class, 'indexqueue'])->name('importcsv.importqueue');
    Route::post('admin/importcsvqueue', [UserImportController::class, 'storequeue'])->name('importcsv.storequeue');

});

Route::view('/jobs', 'jobs');

require __DIR__ . '/settings.php';
