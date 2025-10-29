<?php

use App\Http\Controllers\ShelfController;
use Illuminate\Support\Facades\Route;

Route::prefix('shelves')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ShelfController::class, 'index'])->name('shelves.index');
    Route::get('/{shelf}', [ShelfController::class, 'show'])->name('shelves.show');
    Route::post('/', [ShelfController::class, 'store'])->name('shelves.store');
    Route::put('/{shelf}', [ShelfController::class, 'update'])->name('shelves.update');
    Route::delete('/{shelf}', [ShelfController::class, 'destroy'])->name('shelves.destroy');

    // Relations
    Route::get('/{shelf}/books', [ShelfController::class, 'books'])->name('shelves.books');
    Route::get('/{shelf}/user', [ShelfController::class, 'user'])->name('shelves.user');

    // Book management
    Route::post('/{shelf}/books/{book}', [ShelfController::class, 'addBook'])->name('shelves.books.add');
    Route::delete('/{shelf}/books/{book}', [ShelfController::class, 'removeBook'])->name('shelves.books.remove');
    Route::post('/{shelf}/books/bulk-add', [ShelfController::class, 'bulkAddBooks'])->name('shelves.books.bulk-add');
    Route::delete('/{shelf}/books/bulk-remove', [ShelfController::class, 'bulkRemoveBooks'])->name('shelves.books.bulk-remove');

    // Stats
    Route::get('/{shelf}/stats', [ShelfController::class, 'stats'])->name('shelves.stats');
});
