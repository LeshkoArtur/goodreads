<?php

use App\Http\Controllers\CollectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('collections')->group(function () {
    Route::get('/', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('/{collection}', [CollectionController::class, 'show'])->name('collections.show');

    // Relations
    Route::get('/{collection}/books', [CollectionController::class, 'books'])->name('collections.books');
    Route::get('/{collection}/user', [CollectionController::class, 'user'])->name('collections.user');
    Route::get('/{collection}/posts', [CollectionController::class, 'posts'])->name('collections.posts');

    // Stats
    Route::get('/{collection}/stats', [CollectionController::class, 'stats'])->name('collections.stats');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CollectionController::class, 'store'])->name('collections.store');
        Route::put('/{collection}', [CollectionController::class, 'update'])->name('collections.update');
        Route::delete('/{collection}', [CollectionController::class, 'destroy'])->name('collections.destroy');

        Route::post('/{collection}/books/{book}', [CollectionController::class, 'addBook'])->name('collections.books.add');
        Route::delete('/{collection}/books/{book}', [CollectionController::class, 'removeBook'])->name('collections.books.remove');

        // Collaboration
        Route::post('/{collection}/follow', [CollectionController::class, 'follow'])->name('collections.follow');
        Route::delete('/{collection}/unfollow', [CollectionController::class, 'unfollow'])->name('collections.unfollow');
    });
});
