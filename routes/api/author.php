<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/{author}', [AuthorController::class, 'show'])->name('authors.show');

    // Relations
    Route::get('/{author}/books', [AuthorController::class, 'books'])->name('authors.books');
    Route::get('/{author}/series', [AuthorController::class, 'series'])->name('authors.series');
    Route::get('/{author}/users', [AuthorController::class, 'users'])->name('authors.users');

    // Q&A
    Route::get('/{author}/questions', [AuthorController::class, 'questions'])->name('authors.questions');
    Route::get('/{author}/answers', [AuthorController::class, 'answers'])->name('authors.answers');

    // Content
    Route::get('/{author}/posts', [AuthorController::class, 'posts'])->name('authors.posts');
    Route::get('/{author}/nominations', [AuthorController::class, 'nominations'])->name('authors.nominations');
    Route::get('/{author}/awards', [AuthorController::class, 'awards'])->name('authors.awards');

    // Stats
    Route::get('/{author}/stats', [AuthorController::class, 'stats'])->name('authors.stats');
    Route::get('/{author}/popular-books', [AuthorController::class, 'popularBooks'])->name('authors.popular-books');
    Route::get('/{author}/similar', [AuthorController::class, 'similar'])->name('authors.similar');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
        Route::put('/{author}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');

        // User actions
        Route::post('/{author}/claim', [AuthorController::class, 'claim'])->name('authors.claim');
        Route::post('/{author}/follow', [AuthorController::class, 'follow'])->name('authors.follow');
        Route::delete('/{author}/unfollow', [AuthorController::class, 'unfollow'])->name('authors.unfollow');
    });
});
