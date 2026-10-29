<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LaravelBasicController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::view('/jobs', 'jobs');

Route::get('/counter-reset', [LaravelBasicController::class, 'counterReset'])->name('counter-reset');

Route::get('/name-preview', [LaravelBasicController::class, 'namePreview'])->name('name-preview');
Route::post('/name-preview', [LaravelBasicController::class, 'namePreviewstore'])->name('name-preview-store');

Route::get('/bio-character-counter', [LaravelBasicController::class, 'bioCharacterCounter'])->name('bio-character-counter');
Route::post('/bio-character-counter', [LaravelBasicController::class, 'bioCharacterCounterPost'])->name('bio-character-counter-post');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/settings.php';



