<?php

use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::prefix('likes')->group(function () {
    Route::get('/', [LikeController::class, 'index'])->name('likes.index');
    Route::get('/{like}', [LikeController::class, 'show'])->name('likes.show');

    // Relations
    Route::get('/{like}/user', [LikeController::class, 'user'])->name('likes.user');
    Route::get('/{like}/likeable', [LikeController::class, 'likeable'])->name('likes.likeable');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [LikeController::class, 'store'])->name('likes.store');
        Route::delete('/{like}', [LikeController::class, 'destroy'])->name('likes.destroy');

        // Polymorphic toggle
        Route::post('/toggle', [LikeController::class, 'toggle'])->name('likes.toggle');
    });
});
