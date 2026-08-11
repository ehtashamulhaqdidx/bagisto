<?php

use Illuminate\Support\Facades\Route;

/**
 * Admin routes.
 */
Route::group(['middleware' => ['admin'], 'prefix' => config('app.admin_url')], function () {
    Route::prefix('marketplace')->group(function () {
        Route::get('sellers', [\Webkul\Marketplace\Http\Controllers\Admin\SellerController::class, 'index'])->name('admin.marketplace.sellers.index');
        Route::get('sellers/create', [\Webkul\Marketplace\Http\Controllers\Admin\SellerController::class, 'create'])->name('admin.marketplace.sellers.create');
        Route::post('sellers', [\Webkul\Marketplace\Http\Controllers\Admin\SellerController::class, 'store'])->name('admin.marketplace.sellers.store');
        Route::get('sellers/{id}/edit', [\Webkul\Marketplace\Http\Controllers\Admin\SellerController::class, 'edit'])->name('admin.marketplace.sellers.edit');
        Route::put('sellers/{id}', [\Webkul\Marketplace\Http\Controllers\Admin\SellerController::class, 'update'])->name('admin.marketplace.sellers.update');
            Route::post('sellers/{id}/approve', [\Webkul\Marketplace\Http\Controllers\Admin\SellerController::class, 'approve'])->name('admin.marketplace.sellers.approve');
    });
});

/**
 * Shop routes.
 */
Route::group(['middleware' => ['web'], 'prefix' => 'seller'], function () {
    Route::get('/', [\Webkul\Marketplace\Http\Controllers\Shop\SellerDashboardController::class, 'index'])->name('marketplace.seller.dashboard')->middleware('marketplace.seller.approved');
    Route::get('products/create', [\Webkul\Marketplace\Http\Controllers\Shop\ProductUploadController::class, 'create'])->name('marketplace.seller.products.create')->middleware('marketplace.seller.approved');
    Route::post('products', [\Webkul\Marketplace\Http\Controllers\Shop\ProductUploadController::class, 'store'])->name('marketplace.seller.products.store')->middleware('marketplace.seller.approved');
});

/**
 * Seller request (frontend) routes.
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('become-seller', [\Webkul\Marketplace\Http\Controllers\Shop\SellerRequestController::class, 'create'])
        ->name('marketplace.seller.request');

    Route::post('become-seller', [\Webkul\Marketplace\Http\Controllers\Shop\SellerRequestController::class, 'store'])
        ->middleware('customer')
        ->name('marketplace.seller.request.store');
});
