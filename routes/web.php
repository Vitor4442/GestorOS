<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function (): void {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('service-orders', ServiceOrderController::class)->except(['destroy']);
    Route::patch('service-orders/{service_order}/status', [ServiceOrderController::class, 'updateStatus'])
        ->name('service-orders.status');
    Route::resource('customers', CustomerController::class);
});
