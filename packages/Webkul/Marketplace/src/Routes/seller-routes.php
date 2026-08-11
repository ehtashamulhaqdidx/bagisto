<?php

use Illuminate\Support\Facades\Route;
use Webkul\Marketplace\Http\Controllers\Seller\AuthController;
use Webkul\Marketplace\Http\Controllers\Seller\DashboardController;
use Webkul\Marketplace\Http\Controllers\Seller\InvoiceController;
use Webkul\Marketplace\Http\Controllers\Seller\OrderController;
use Webkul\Marketplace\Http\Controllers\Seller\PayoutController;
use Webkul\Marketplace\Http\Controllers\Seller\ProductController;
use Webkul\Marketplace\Http\Controllers\Seller\ShipmentController;

Route::prefix('marketplace/seller')->group(function () {

    // Guest-only auth routes
    Route::middleware('guest:seller')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('marketplace.seller.login');
        Route::post('login', [AuthController::class, 'login'])->name('marketplace.seller.login.store');
        Route::get('register', [AuthController::class, 'showRegister'])->name('marketplace.seller.register');
        Route::post('register', [AuthController::class, 'register'])->name('marketplace.seller.register.store');
    });

    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware('auth:seller')
        ->name('marketplace.seller.logout');

    // Status page reachable even when pending/disapproved/suspended
    Route::get('status', [AuthController::class, 'status'])
        ->middleware('auth:seller')
        ->name('marketplace.seller.status');

    // Everything below requires an approved seller
    Route::middleware('marketplace.seller')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('marketplace.seller.dashboard');

        Route::get('products', [ProductController::class, 'index'])->name('marketplace.seller.products.index');
        Route::get('products/create', [ProductController::class, 'create'])->name('marketplace.seller.products.create');
        Route::post('products', [ProductController::class, 'store'])->name('marketplace.seller.products.store');
        Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('marketplace.seller.products.edit');
        Route::put('products/{id}', [ProductController::class, 'update'])->name('marketplace.seller.products.update');
        Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('marketplace.seller.products.destroy');

        Route::get('orders', [OrderController::class, 'index'])->name('marketplace.seller.orders.index');
        Route::get('orders/{id}', [OrderController::class, 'show'])->name('marketplace.seller.orders.show');
        Route::post('orders/{id}/shipments', [ShipmentController::class, 'store'])->name('marketplace.seller.orders.shipments.store');
        Route::post('orders/{id}/invoices', [InvoiceController::class, 'store'])->name('marketplace.seller.orders.invoices.store');

        Route::get('payouts', [PayoutController::class, 'index'])->name('marketplace.seller.payouts.index');
        Route::post('payouts', [PayoutController::class, 'store'])->name('marketplace.seller.payouts.store');
    });
});
