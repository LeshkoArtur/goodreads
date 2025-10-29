<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('tags.index');

    // Stats (must be before /{tag} to avoid route conflicts)
    Route::get('/popular', [TagController::class, 'popular'])->name('tags.popular');
    Route::get('/trending', [TagController::class, 'trending'])->name('tags.trending');

    Route::get('/{tag}', [TagController::class, 'show'])->name('tags.show');

    // Tagged items
    Route::get('/{tag}/items', [TagController::class, 'items'])->name('tags.items');
    Route::get('/{tag}/books', [TagController::class, 'books'])->name('tags.books');
    Route::get('/{tag}/posts', [TagController::class, 'posts'])->name('tags.posts');

    // Stats
    Route::get('/{tag}/usage-count', [TagController::class, 'usageCount'])->name('tags.usage-count');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [TagController::class, 'store'])->name('tags.store');
        Route::put('/{tag}', [TagController::class, 'update'])->name('tags.update');
        Route::delete('/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

        // Tagging actions
        Route::post('/{tag}/attach', [TagController::class, 'attach'])->name('tags.attach');
        Route::delete('/{tag}/detach', [TagController::class, 'detach'])->name('tags.detach');
        Route::post('/bulk-attach', [TagController::class, 'bulkAttach'])->name('tags.bulk-attach');
    });
});
