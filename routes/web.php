<?php

use App\Http\Controllers\RolePermissionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/role-permissions', [RolePermissionController::class, 'index'])->name('permission.index');
});

Route::view('/jobs', 'jobs');

require __DIR__.'/settings.php';
