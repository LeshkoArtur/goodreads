<?php

use App\Http\Controllers\AuthorAnswerController;
use Illuminate\Support\Facades\Route;

Route::prefix('author-answers')->group(function () {
    Route::get('/', [AuthorAnswerController::class, 'index'])->name('author-answers.index');
    Route::get('/{authorAnswer}', [AuthorAnswerController::class, 'show'])->name('author-answers.show');

    // Relations
    Route::get('/{authorAnswer}/author', [AuthorAnswerController::class, 'author'])->name('author-answers.author');
    Route::get('/{authorAnswer}/question', [AuthorAnswerController::class, 'question'])->name('author-answers.question');
    Route::get('/{authorAnswer}/answerer', [AuthorAnswerController::class, 'answerer'])->name('author-answers.answerer');
    Route::get('/{authorAnswer}/likes', [AuthorAnswerController::class, 'likes'])->name('author-answers.likes');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [AuthorAnswerController::class, 'store'])->name('author-answers.store');
        Route::put('/{authorAnswer}', [AuthorAnswerController::class, 'update'])->name('author-answers.update');
        Route::delete('/{authorAnswer}', [AuthorAnswerController::class, 'destroy'])->name('author-answers.destroy');

        // Actions
        Route::post('/{authorAnswer}/like', [AuthorAnswerController::class, 'like'])->name('author-answers.like');
        Route::delete('/{authorAnswer}/unlike', [AuthorAnswerController::class, 'unlike'])->name('author-answers.unlike');
        Route::post('/{authorAnswer}/approve', [AuthorAnswerController::class, 'approve'])->name('author-answers.approve');
        Route::post('/{authorAnswer}/reject', [AuthorAnswerController::class, 'reject'])->name('author-answers.reject');
    });
});
