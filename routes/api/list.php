<?php

use App\Http\Controllers\ListController;
use Illuminate\Support\Facades\Route;

Route::prefix('lists')->group(function () {
    // Public lists
    Route::get('/', [ListController::class, 'index'])->name('lists.index');
    Route::get('/{list}', [ListController::class, 'show'])->name('lists.show');
    Route::get('/popular', [ListController::class, 'popular'])->name('lists.popular');
    Route::get('/trending', [ListController::class, 'trending'])->name('lists.trending');
    Route::get('/featured', [ListController::class, 'featured'])->name('lists.featured');

    // List items
    Route::get('/{list}/items', [ListController::class, 'items'])->name('lists.items');
    Route::get('/{list}/books', [ListController::class, 'books'])->name('lists.books');
    Route::get('/{list}/stats', [ListController::class, 'stats'])->name('lists.stats');

    // Filtering
    Route::get('/category/{category}', [ListController::class, 'byCategory'])->name('lists.by-category');
    Route::get('/genre/{genre}', [ListController::class, 'byGenre'])->name('lists.by-genre');
    Route::get('/user/{user}', [ListController::class, 'byUser'])->name('lists.by-user');

    Route::middleware('auth:sanctum')->group(function () {
        // My lists
        Route::get('/my/created', [ListController::class, 'myCreated'])->name('lists.my-created');
        Route::get('/my/saved', [ListController::class, 'mySaved'])->name('lists.my-saved');

        // List management
        Route::post('/', [ListController::class, 'store'])->name('lists.store');
        Route::put('/{list}', [ListController::class, 'update'])->name('lists.update');
        Route::delete('/{list}', [ListController::class, 'destroy'])->name('lists.destroy');

        // Items management
        Route::post('/{list}/items', [ListController::class, 'addItem'])->name('lists.add-item');
        Route::delete('/{list}/items/{item}', [ListController::class, 'removeItem'])->name('lists.remove-item');
        Route::put('/{list}/items/reorder', [ListController::class, 'reorderItems'])->name('lists.reorder-items');
        Route::post('/{list}/items/bulk-add', [ListController::class, 'bulkAddItems'])->name('lists.bulk-add-items');

        // List actions
        Route::post('/{list}/save', [ListController::class, 'save'])->name('lists.save');
        Route::delete('/{list}/unsave', [ListController::class, 'unsave'])->name('lists.unsave');
        Route::post('/{list}/vote', [ListController::class, 'vote'])->name('lists.vote');
        Route::delete('/{list}/unvote', [ListController::class, 'unvote'])->name('lists.unvote');

        // Collaboration
        Route::post('/{list}/collaborators/{user}', [ListController::class, 'addCollaborator'])->name('lists.add-collaborator');
        Route::delete('/{list}/collaborators/{user}', [ListController::class, 'removeCollaborator'])->name('lists.remove-collaborator');
    });
});
