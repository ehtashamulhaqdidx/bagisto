<?php

use Illuminate\Support\Facades\Route;
use Webkul\Marketplace\Http\Controllers\Admin\CommissionController;
use Webkul\Marketplace\Http\Controllers\Admin\PayoutController;
use Webkul\Marketplace\Http\Controllers\Admin\SellerController;

// Sits under Bagisto's existing admin route group / auth:admin + admin locale
// middleware, mirroring how other Bagisto admin packages register routes.
Route::group(['middleware' => ['web', 'admin_locale', 'auth:admin']], function () {

    Route::prefix('admin/marketplace')->group(function () {
        Route::get('sellers', [SellerController::class, 'index'])->name('marketplace.admin.sellers.index');
        Route::get('sellers/{id}/edit', [SellerController::class, 'edit'])->name('marketplace.admin.sellers.edit');
        Route::put('sellers/{id}', [SellerController::class, 'update'])->name('marketplace.admin.sellers.update');
        Route::delete('sellers/{id}', [SellerController::class, 'destroy'])->name('marketplace.admin.sellers.destroy');

        Route::get('commissions', [CommissionController::class, 'index'])->name('marketplace.admin.commissions.index');

        Route::get('payouts', [PayoutController::class, 'index'])->name('marketplace.admin.payouts.index');
        Route::post('payouts/{id}/approve', [PayoutController::class, 'approve'])->name('marketplace.admin.payouts.approve');
        Route::post('payouts/{id}/reject', [PayoutController::class, 'reject'])->name('marketplace.admin.payouts.reject');
        Route::post('payouts/{id}/mark-paid', [PayoutController::class, 'markPaid'])->name('marketplace.admin.payouts.mark-paid');
    });
});
