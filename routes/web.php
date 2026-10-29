<?php

use App\Http\Controllers\LaravelBasicController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::view('/jobs', 'jobs');

Route::get('/counter-reset', [LaravelBasicController::class, 'counterReset'])->name('counterReset');

require __DIR__.'/settings.php';



