<?php

use App\Http\Controllers\AuthorQuestionController;
use Illuminate\Support\Facades\Route;

Route::prefix('author-questions')->group(function () {
    Route::get('/', [AuthorQuestionController::class, 'index'])->name('author-questions.index');
    Route::get('/{authorQuestion}', [AuthorQuestionController::class, 'show'])->name('author-questions.show');

    // Relations
    Route::get('/{authorQuestion}/author', [AuthorQuestionController::class, 'author'])->name('author-questions.author');
    Route::get('/{authorQuestion}/asker', [AuthorQuestionController::class, 'asker'])->name('author-questions.asker');
    Route::get('/{authorQuestion}/book', [AuthorQuestionController::class, 'book'])->name('author-questions.book');
    Route::get('/{authorQuestion}/answers', [AuthorQuestionController::class, 'answers'])->name('author-questions.answers');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [AuthorQuestionController::class, 'store'])->name('author-questions.store');
        Route::put('/{authorQuestion}', [AuthorQuestionController::class, 'update'])->name('author-questions.update');
        Route::delete('/{authorQuestion}', [AuthorQuestionController::class, 'destroy'])->name('author-questions.destroy');

        // Actions
        Route::post('/{authorQuestion}/upvote', [AuthorQuestionController::class, 'upvote'])->name('author-questions.upvote');
        Route::delete('/{authorQuestion}/upvote', [AuthorQuestionController::class, 'removeUpvote'])->name('author-questions.remove-upvote');
    });
});
