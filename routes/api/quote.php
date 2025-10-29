<?php

use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::prefix('quotes')->group(function () {
    Route::get('/', [QuoteController::class, 'index'])->name('quotes.index');
    Route::get('/{quote}', [QuoteController::class, 'show'])->name('quotes.show');

    // Relations
    Route::get('/{quote}/user', [QuoteController::class, 'user'])->name('quotes.user');
    Route::get('/{quote}/book', [QuoteController::class, 'book'])->name('quotes.book');
    Route::get('/{quote}/likes', [QuoteController::class, 'likes'])->name('quotes.likes');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [QuoteController::class, 'store'])->name('quotes.store');
        Route::put('/{quote}', [QuoteController::class, 'update'])->name('quotes.update');
        Route::delete('/{quote}', [QuoteController::class, 'destroy'])->name('quotes.destroy');

        // Actions
        Route::post('/{quote}/like', [QuoteController::class, 'like'])->name('quotes.like');
        Route::delete('/{quote}/unlike', [QuoteController::class, 'unlike'])->name('quotes.unlike');
        Route::post('/{quote}/favorite', [QuoteController::class, 'favorite'])->name('quotes.favorite');
        Route::delete('/{quote}/unfavorite', [QuoteController::class, 'unfavorite'])->name('quotes.unfavorite');
    });
});
