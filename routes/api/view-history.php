<?php

use App\Http\Controllers\ViewHistoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('view-history')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ViewHistoryController::class, 'index'])->name('view-history.index');

    // Filtering by type (static routes must come before dynamic parameters)
    Route::get('/books', [ViewHistoryController::class, 'books'])->name('view-history.books');
    Route::get('/authors', [ViewHistoryController::class, 'authors'])->name('view-history.authors');
    Route::get('/posts', [ViewHistoryController::class, 'posts'])->name('view-history.posts');

    // Stats & Analytics
    Route::get('/recent', [ViewHistoryController::class, 'recent'])->name('view-history.recent');
    Route::get('/most-viewed', [ViewHistoryController::class, 'mostViewed'])->name('view-history.most-viewed');

    Route::get('/{viewHistory}', [ViewHistoryController::class, 'show'])->name('view-history.show');

    // Relations
    Route::get('/{viewHistory}/user', [ViewHistoryController::class, 'user'])->name('view-history.user');
    Route::get('/{viewHistory}/viewable', [ViewHistoryController::class, 'viewable'])->name('view-history.viewable');

    Route::post('/', [ViewHistoryController::class, 'store'])->name('view-history.store');
    Route::delete('/{viewHistory}', [ViewHistoryController::class, 'destroy'])->name('view-history.destroy');

    // Bulk actions
    Route::delete('/clear', [ViewHistoryController::class, 'clear'])->name('view-history.clear');
    Route::delete('/clear-type/{type}', [ViewHistoryController::class, 'clearByType'])->name('view-history.clear-type');
});
