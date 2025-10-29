<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::prefix('comments')->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('comments.index');
    Route::get('/{comment}', [CommentController::class, 'show'])->name('comments.show');

    // Relations
    Route::get('/{comment}/user', [CommentController::class, 'user'])->name('comments.user');
    Route::get('/{comment}/replies', [CommentController::class, 'replies'])->name('comments.replies');
    Route::get('/{comment}/likes', [CommentController::class, 'likes'])->name('comments.likes');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [CommentController::class, 'store'])->name('comments.store');
        Route::put('/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

        // Actions
        Route::post('/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
        Route::delete('/{comment}/unlike', [CommentController::class, 'unlike'])->name('comments.unlike');
        Route::post('/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    });
});
