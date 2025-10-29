<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::prefix('search')->group(function () {
    // Global search
    Route::get('/', [SearchController::class, 'global'])->name('search.global');
    Route::get('/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

    // Search by type
    Route::get('/books', [SearchController::class, 'books'])->name('search.books');
    Route::get('/authors', [SearchController::class, 'authors'])->name('search.authors');
    Route::get('/users', [SearchController::class, 'users'])->name('search.users');
    Route::get('/groups', [SearchController::class, 'groups'])->name('search.groups');
    Route::get('/posts', [SearchController::class, 'posts'])->name('search.posts');
    Route::get('/quotes', [SearchController::class, 'quotes'])->name('search.quotes');
    Route::get('/collections', [SearchController::class, 'collections'])->name('search.collections');

    // Advanced search
    Route::post('/advanced', [SearchController::class, 'advanced'])->name('search.advanced');
    Route::get('/filters', [SearchController::class, 'availableFilters'])->name('search.filters');

    // Search history
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/history', [SearchController::class, 'history'])->name('search.history');
        Route::delete('/history/clear', [SearchController::class, 'clearHistory'])->name('search.clear-history');
        Route::post('/save', [SearchController::class, 'saveSearch'])->name('search.save');
        Route::get('/saved', [SearchController::class, 'savedSearches'])->name('search.saved');
    });
});
