<?php

use App\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Route;

Route::prefix('feed')->middleware('auth:sanctum')->group(function () {
    // Main feeds
    Route::get('/', [FeedController::class, 'index'])->name('feed.index');
    Route::get('/home', [FeedController::class, 'home'])->name('feed.home');
    Route::get('/following', [FeedController::class, 'following'])->name('feed.following');
    Route::get('/discover', [FeedController::class, 'discover'])->name('feed.discover');

    // Activity feeds
    Route::get('/friends', [FeedController::class, 'friends'])->name('feed.friends');
    Route::get('/groups', [FeedController::class, 'groups'])->name('feed.groups');
    Route::get('/authors', [FeedController::class, 'authors'])->name('feed.authors');

    // Content type feeds
    Route::get('/reviews', [FeedController::class, 'reviews'])->name('feed.reviews');
    Route::get('/quotes', [FeedController::class, 'quotes'])->name('feed.quotes');
    Route::get('/discussions', [FeedController::class, 'discussions'])->name('feed.discussions');
    Route::get('/updates', [FeedController::class, 'updates'])->name('feed.updates');

    // Genre-specific feed
    Route::get('/genre/{genre}', [FeedController::class, 'byGenre'])->name('feed.by-genre');

    // User-specific feed
    Route::get('/user/{user}', [FeedController::class, 'user'])->name('feed.user');

    // Feed preferences
    Route::get('/preferences', [FeedController::class, 'getPreferences'])->name('feed.get-preferences');
    Route::put('/preferences', [FeedController::class, 'updatePreferences'])->name('feed.update-preferences');

    // Mark as read
    Route::post('/mark-read', [FeedController::class, 'markAsRead'])->name('feed.mark-read');
    Route::post('/mark-all-read', [FeedController::class, 'markAllAsRead'])->name('feed.mark-all-read');
});
