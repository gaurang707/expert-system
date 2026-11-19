<?php

use App\Http\Controllers\OrderStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::patch('{order}/status', [OrderStatusController::class, 'statusChange'])->name('order.status.change');