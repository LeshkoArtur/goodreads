<?php

use App\Http\Controllers\TrendingController;
use Illuminate\Support\Facades\Route;

Route::prefix('trending')->group(function () {
    // Overall trending
    Route::get('/', [TrendingController::class, 'index'])->name('trending.index');

    // Trending by type
    Route::get('/books', [TrendingController::class, 'books'])->name('trending.books');
    Route::get('/authors', [TrendingController::class, 'authors'])->name('trending.authors');
    Route::get('/genres', [TrendingController::class, 'genres'])->name('trending.genres');
    Route::get('/quotes', [TrendingController::class, 'quotes'])->name('trending.quotes');
    Route::get('/posts', [TrendingController::class, 'posts'])->name('trending.posts');
    Route::get('/discussions', [TrendingController::class, 'discussions'])->name('trending.discussions');
    Route::get('/groups', [TrendingController::class, 'groups'])->name('trending.groups');
    Route::get('/tags', [TrendingController::class, 'tags'])->name('trending.tags');

    // Time-based trending
    Route::get('/today', [TrendingController::class, 'today'])->name('trending.today');
    Route::get('/this-week', [TrendingController::class, 'thisWeek'])->name('trending.this-week');
    Route::get('/this-month', [TrendingController::class, 'thisMonth'])->name('trending.this-month');

    // Trending by genre
    Route::get('/genre/{genre}', [TrendingController::class, 'byGenre'])->name('trending.by-genre');
});
