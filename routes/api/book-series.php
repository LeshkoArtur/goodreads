<?php

use App\Http\Controllers\BookSeriesController;
use Illuminate\Support\Facades\Route;

Route::prefix('book-series')->group(function () {
    Route::get('/', [BookSeriesController::class, 'index'])->name('book-series.index');
    Route::get('/{bookSeries}', [BookSeriesController::class, 'show'])->name('book-series.show');

    // Relations
    Route::get('/{bookSeries}/books', [BookSeriesController::class, 'books'])->name('book-series.books');
    Route::get('/{bookSeries}/author', [BookSeriesController::class, 'author'])->name('book-series.author');

    // Stats
    Route::get('/{bookSeries}/stats', [BookSeriesController::class, 'stats'])->name('book-series.stats');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [BookSeriesController::class, 'store'])->name('book-series.store');
        Route::put('/{bookSeries}', [BookSeriesController::class, 'update'])->name('book-series.update');
        Route::delete('/{bookSeries}', [BookSeriesController::class, 'destroy'])->name('book-series.destroy');
    });
});
