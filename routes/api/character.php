<?php

use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::prefix('characters')->group(function () {
    Route::get('/', [CharacterController::class, 'index'])->name('characters.index');
    Route::get('/{character}', [CharacterController::class, 'show'])->name('characters.show');

    // Relations
    Route::get('/{character}/book', [CharacterController::class, 'book'])->name('characters.book');

    // Stats
    Route::get('/{character}/stats', [CharacterController::class, 'stats'])->name('characters.stats');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CharacterController::class, 'store'])->name('characters.store');
        Route::put('/{character}', [CharacterController::class, 'update'])->name('characters.update');
        Route::delete('/{character}', [CharacterController::class, 'destroy'])->name('characters.destroy');

        // Actions
        Route::post('/{character}/favorite', [CharacterController::class, 'favorite'])->name('characters.favorite');
        Route::delete('/{character}/unfavorite', [CharacterController::class, 'unfavorite'])->name('characters.unfavorite');
    });
});
