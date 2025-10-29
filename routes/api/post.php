<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');

    // Relations
    Route::get('/{post}/comments', [PostController::class, 'comments'])->name('posts.comments');
    Route::get('/{post}/likes', [PostController::class, 'likes'])->name('posts.likes');
    Route::get('/{post}/user', [PostController::class, 'user'])->name('posts.user');
    Route::get('/{post}/book', [PostController::class, 'book'])->name('posts.book');
    Route::get('/{post}/author', [PostController::class, 'author'])->name('posts.author');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        // Actions
        Route::post('/{post}/like', [PostController::class, 'like'])->name('posts.like');
        Route::delete('/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');
        Route::post('/{post}/favorite', [PostController::class, 'favorite'])->name('posts.favorite');
        Route::delete('/{post}/unfavorite', [PostController::class, 'unfavorite'])->name('posts.unfavorite');
    });
});
