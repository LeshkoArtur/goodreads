<?php

use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::prefix('ratings')->group(function () {
    Route::get('/', [RatingController::class, 'index'])->name('ratings.index');
    Route::get('/{rating}', [RatingController::class, 'show'])->name('ratings.show');

    // Relations
    Route::get('/{rating}/user', [RatingController::class, 'user'])->name('ratings.user');
    Route::get('/{rating}/book', [RatingController::class, 'book'])->name('ratings.book');
    Route::get('/{rating}/comments', [RatingController::class, 'comments'])->name('ratings.comments');
    Route::get('/{rating}/likes', [RatingController::class, 'likes'])->name('ratings.likes');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [RatingController::class, 'store'])->name('ratings.store');
        Route::put('/{rating}', [RatingController::class, 'update'])->name('ratings.update');
        Route::delete('/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');

        // Actions
        Route::post('/{rating}/like', [RatingController::class, 'like'])->name('ratings.like');
        Route::delete('/{rating}/unlike', [RatingController::class, 'unlike'])->name('ratings.unlike');
    });
});
