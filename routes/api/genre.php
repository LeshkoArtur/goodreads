<?php

use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

Route::prefix('genres')->group(function () {
    Route::get('/', [GenreController::class, 'index'])->name('genres.index');
    Route::get('/{genre}', [GenreController::class, 'show'])->name('genres.show');

    // Relations
    Route::get('/{genre}/books', [GenreController::class, 'books'])->name('genres.books');
    Route::get('/{genre}/subgenres', [GenreController::class, 'subgenres'])->name('genres.subgenres');
    Route::get('/{genre}/parent', [GenreController::class, 'parent'])->name('genres.parent');

    // Stats & Discovery
    Route::get('/{genre}/popular-books', [GenreController::class, 'popularBooks'])->name('genres.popular-books');
    Route::get('/{genre}/trending-books', [GenreController::class, 'trendingBooks'])->name('genres.trending-books');
    Route::get('/{genre}/new-releases', [GenreController::class, 'newReleases'])->name('genres.new-releases');
    Route::get('/{genre}/stats', [GenreController::class, 'stats'])->name('genres.stats');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [GenreController::class, 'store'])->name('genres.store');
        Route::put('/{genre}', [GenreController::class, 'update'])->name('genres.update');
        Route::delete('/{genre}', [GenreController::class, 'destroy'])->name('genres.destroy');
    });
});
