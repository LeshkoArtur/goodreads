<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');

    // Relations
    Route::get('/{user}/books', [UserController::class, 'books'])->name('users.books');
    Route::get('/{user}/shelves', [UserController::class, 'shelves'])->name('users.shelves');
    Route::get('/{user}/ratings', [UserController::class, 'ratings'])->name('users.ratings');
    Route::get('/{user}/quotes', [UserController::class, 'quotes'])->name('users.quotes');
    Route::get('/{user}/comments', [UserController::class, 'comments'])->name('users.comments');
    Route::get('/{user}/following', [UserController::class, 'following'])->name('users.following');
    Route::get('/{user}/followers', [UserController::class, 'followers'])->name('users.followers');
    Route::get('/{user}/groups', [UserController::class, 'groups'])->name('users.groups');

    // Stats
    Route::get('/{user}/stats', [UserController::class, 'stats'])->name('users.stats');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // User actions
        Route::post('/{user}/follow', [UserController::class, 'follow'])->name('users.follow');
        Route::delete('/{user}/unfollow', [UserController::class, 'unfollow'])->name('users.unfollow');
    });
});
