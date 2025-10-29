<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::prefix('favorites')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');

    // Filtering by type (static routes must come before dynamic parameters)
    Route::get('/books', [FavoriteController::class, 'books'])->name('favorites.books');
    Route::get('/authors', [FavoriteController::class, 'authors'])->name('favorites.authors');
    Route::get('/quotes', [FavoriteController::class, 'quotes'])->name('favorites.quotes');
    Route::get('/posts', [FavoriteController::class, 'posts'])->name('favorites.posts');

    Route::get('/{favorite}', [FavoriteController::class, 'show'])->name('favorites.show');

    // Relations
    Route::get('/{favorite}/user', [FavoriteController::class, 'user'])->name('favorites.user');
    Route::get('/{favorite}/favoriteable', [FavoriteController::class, 'favoriteable'])->name('favorites.favoriteable');

    Route::post('/', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/{favorite}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Polymorphic toggle
    Route::post('/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});
