<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::prefix('stores')->group(function () {
    Route::get('/', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/{store}', [StoreController::class, 'show'])->name('stores.show');

    // Relations
    Route::get('/{store}/offers', [StoreController::class, 'offers'])->name('stores.offers');
    Route::get('/{store}/active-offers', [StoreController::class, 'activeOffers'])->name('stores.active-offers');

    // Stats
    Route::get('/{store}/stats', [StoreController::class, 'stats'])->name('stores.stats');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [StoreController::class, 'store'])->name('stores.store');
        Route::put('/{store}', [StoreController::class, 'update'])->name('stores.update');
        Route::delete('/{store}', [StoreController::class, 'destroy'])->name('stores.destroy');
    });
});
