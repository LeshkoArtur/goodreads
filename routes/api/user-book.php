<?php

use App\Http\Controllers\UserBookController;
use Illuminate\Support\Facades\Route;

Route::prefix('user-books')->group(function () {
    Route::get('/', [UserBookController::class, 'index'])->name('user-books.index');
    Route::get('/{userBook}', [UserBookController::class, 'show'])->name('user-books.show');

    // Relations
    Route::get('/{userBook}/user', [UserBookController::class, 'user'])->name('user-books.user');
    Route::get('/{userBook}/book', [UserBookController::class, 'book'])->name('user-books.book');
    Route::get('/{userBook}/ratings', [UserBookController::class, 'ratings'])->name('user-books.ratings');
    Route::get('/{userBook}/notes', [UserBookController::class, 'notes'])->name('user-books.notes');
    Route::get('/{userBook}/quotes', [UserBookController::class, 'quotes'])->name('user-books.quotes');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [UserBookController::class, 'store'])->name('user-books.store');
        Route::put('/{userBook}', [UserBookController::class, 'update'])->name('user-books.update');
        Route::delete('/{userBook}', [UserBookController::class, 'destroy'])->name('user-books.destroy');

        // Reading progress
        Route::put('/{userBook}/progress', [UserBookController::class, 'updateProgress'])->name('user-books.update-progress');
        Route::put('/{userBook}/status', [UserBookController::class, 'updateStatus'])->name('user-books.update-status');
        Route::post('/{userBook}/mark-finished', [UserBookController::class, 'markFinished'])->name('user-books.mark-finished');
    });
});
