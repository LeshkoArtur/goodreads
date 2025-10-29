<?php

use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::prefix('recommendations')->middleware('auth:sanctum')->group(function () {
    // Personalized recommendations
    Route::get('/', [RecommendationController::class, 'index'])->name('recommendations.index');
    Route::get('/books', [RecommendationController::class, 'books'])->name('recommendations.books');
    Route::get('/authors', [RecommendationController::class, 'authors'])->name('recommendations.authors');
    Route::get('/groups', [RecommendationController::class, 'groups'])->name('recommendations.groups');
    Route::get('/users', [RecommendationController::class, 'users'])->name('recommendations.users');

    // Based on specific item
    Route::get('/based-on-book/{book}', [RecommendationController::class, 'basedOnBook'])->name('recommendations.based-on-book');
    Route::get('/based-on-author/{author}', [RecommendationController::class, 'basedOnAuthor'])->name('recommendations.based-on-author');
    Route::get('/based-on-genre/{genre}', [RecommendationController::class, 'basedOnGenre'])->name('recommendations.based-on-genre');

    // Discovery
    Route::get('/new-releases', [RecommendationController::class, 'newReleases'])->name('recommendations.new-releases');
    Route::get('/hidden-gems', [RecommendationController::class, 'hiddenGems'])->name('recommendations.hidden-gems');
    Route::get('/bestsellers', [RecommendationController::class, 'bestsellers'])->name('recommendations.bestsellers');
    Route::get('/award-winners', [RecommendationController::class, 'awardWinners'])->name('recommendations.award-winners');

    // Friends' activity
    Route::get('/friends-reading', [RecommendationController::class, 'friendsReading'])->name('recommendations.friends-reading');
    Route::get('/friends-favorites', [RecommendationController::class, 'friendsFavorites'])->name('recommendations.friends-favorites');

    // Feedback
    Route::post('/feedback', [RecommendationController::class, 'feedback'])->name('recommendations.feedback');
    Route::post('/dismiss/{type}/{id}', [RecommendationController::class, 'dismiss'])->name('recommendations.dismiss');
});
