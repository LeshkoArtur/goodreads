<?php

use App\Http\Controllers\GroupPostController;
use Illuminate\Support\Facades\Route;

Route::prefix('group-posts')->group(function () {
    Route::get('/', [GroupPostController::class, 'index'])->name('group-posts.index');
    Route::get('/{groupPost}', [GroupPostController::class, 'show'])->name('group-posts.show');

    // Relations
    Route::get('/{groupPost}/group', [GroupPostController::class, 'group'])->name('group-posts.group');
    Route::get('/{groupPost}/user', [GroupPostController::class, 'user'])->name('group-posts.user');
    Route::get('/{groupPost}/comments', [GroupPostController::class, 'comments'])->name('group-posts.comments');
    Route::get('/{groupPost}/likes', [GroupPostController::class, 'likes'])->name('group-posts.likes');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [GroupPostController::class, 'store'])->name('group-posts.store');
        Route::put('/{groupPost}', [GroupPostController::class, 'update'])->name('group-posts.update');
        Route::delete('/{groupPost}', [GroupPostController::class, 'destroy'])->name('group-posts.destroy');

        // Actions
        Route::post('/{groupPost}/like', [GroupPostController::class, 'like'])->name('group-posts.like');
        Route::delete('/{groupPost}/unlike', [GroupPostController::class, 'unlike'])->name('group-posts.unlike');
        Route::post('/{groupPost}/pin', [GroupPostController::class, 'pin'])->name('group-posts.pin');
        Route::delete('/{groupPost}/unpin', [GroupPostController::class, 'unpin'])->name('group-posts.unpin');
    });
});
