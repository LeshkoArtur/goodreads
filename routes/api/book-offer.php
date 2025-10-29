<?php

use App\Http\Controllers\BookOfferController;
use Illuminate\Support\Facades\Route;

Route::prefix('book-offers')->group(function () {
    Route::get('/', [BookOfferController::class, 'index'])->name('book-offers.index');
    Route::get('/{bookOffer}', [BookOfferController::class, 'show'])->name('book-offers.show');

    // Relations
    Route::get('/{bookOffer}/book', [BookOfferController::class, 'book'])->name('book-offers.book');
    Route::get('/{bookOffer}/store', [BookOfferController::class, 'storeRelation'])->name('book-offers.store-relation');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [BookOfferController::class, 'store'])->name('book-offers.store');
        Route::put('/{bookOffer}', [BookOfferController::class, 'update'])->name('book-offers.update');
        Route::delete('/{bookOffer}', [BookOfferController::class, 'destroy'])->name('book-offers.destroy');
    });
});
