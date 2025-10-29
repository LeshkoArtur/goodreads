<?php

use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;

Route::prefix('publishers')->group(function () {
    Route::get('/', [PublisherController::class, 'index'])->name('publishers.index');
    Route::get('/{publisher}', [PublisherController::class, 'show'])->name('publishers.show');

    // Relations
    Route::get('/{publisher}/books', [PublisherController::class, 'books'])->name('publishers.books');

    // Stats
    Route::get('/{publisher}/popular-books', [PublisherController::class, 'popularBooks'])->name('publishers.popular-books');
    Route::get('/{publisher}/new-releases', [PublisherController::class, 'newReleases'])->name('publishers.new-releases');
    Route::get('/{publisher}/stats', [PublisherController::class, 'stats'])->name('publishers.stats');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PublisherController::class, 'store'])->name('publishers.store');
        Route::put('/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
        Route::delete('/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');
    });
});
