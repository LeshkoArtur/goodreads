<?php

use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::prefix('statistics')->group(function () {
    // Global statistics
    Route::get('/', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/overview', [StatisticsController::class, 'overview'])->name('statistics.overview');

    // Books statistics
    Route::get('/books', [StatisticsController::class, 'books'])->name('statistics.books');
    Route::get('/books/most-read', [StatisticsController::class, 'mostReadBooks'])->name('statistics.most-read-books');
    Route::get('/books/highest-rated', [StatisticsController::class, 'highestRatedBooks'])->name('statistics.highest-rated-books');
    Route::get('/books/most-reviewed', [StatisticsController::class, 'mostReviewedBooks'])->name('statistics.most-reviewed-books');
    Route::get('/books/by-year', [StatisticsController::class, 'booksByYear'])->name('statistics.books-by-year');

    // Authors statistics
    Route::get('/authors', [StatisticsController::class, 'authors'])->name('statistics.authors');
    Route::get('/authors/most-popular', [StatisticsController::class, 'mostPopularAuthors'])->name('statistics.most-popular-authors');
    Route::get('/authors/most-followed', [StatisticsController::class, 'mostFollowedAuthors'])->name('statistics.most-followed-authors');

    // Genres statistics
    Route::get('/genres', [StatisticsController::class, 'genres'])->name('statistics.genres');
    Route::get('/genres/most-popular', [StatisticsController::class, 'mostPopularGenres'])->name('statistics.most-popular-genres');
    Route::get('/genres/trending', [StatisticsController::class, 'trendingGenres'])->name('statistics.trending-genres');

    // Users statistics
    Route::get('/users', [StatisticsController::class, 'users'])->name('statistics.users');
    Route::get('/users/most-active', [StatisticsController::class, 'mostActiveUsers'])->name('statistics.most-active-users');
    Route::get('/users/top-reviewers', [StatisticsController::class, 'topReviewers'])->name('statistics.top-reviewers');

    // Groups statistics
    Route::get('/groups', [StatisticsController::class, 'groups'])->name('statistics.groups');
    Route::get('/groups/largest', [StatisticsController::class, 'largestGroups'])->name('statistics.largest-groups');
    Route::get('/groups/most-active', [StatisticsController::class, 'mostActiveGroups'])->name('statistics.most-active-groups');

    // Reading statistics
    Route::get('/reading', [StatisticsController::class, 'reading'])->name('statistics.reading');
    Route::get('/reading/pages-read', [StatisticsController::class, 'pagesRead'])->name('statistics.pages-read');
    Route::get('/reading/time-spent', [StatisticsController::class, 'timeSpent'])->name('statistics.time-spent');
    Route::get('/reading/completion-rate', [StatisticsController::class, 'completionRate'])->name('statistics.completion-rate');

    // Time-based statistics
    Route::get('/daily', [StatisticsController::class, 'daily'])->name('statistics.daily');
    Route::get('/weekly', [StatisticsController::class, 'weekly'])->name('statistics.weekly');
    Route::get('/monthly', [StatisticsController::class, 'monthly'])->name('statistics.monthly');
    Route::get('/yearly', [StatisticsController::class, 'yearly'])->name('statistics.yearly');
});
