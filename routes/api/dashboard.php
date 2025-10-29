<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware('auth:sanctum')->group(function () {
    // Main dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/overview', [DashboardController::class, 'overview'])->name('dashboard.overview');

    // Reading stats
    Route::get('/reading-stats', [DashboardController::class, 'readingStats'])->name('dashboard.reading-stats');
    Route::get('/reading-challenge', [DashboardController::class, 'readingChallenge'])->name('dashboard.reading-challenge');
    Route::get('/reading-progress', [DashboardController::class, 'readingProgress'])->name('dashboard.reading-progress');
    Route::get('/reading-history', [DashboardController::class, 'readingHistory'])->name('dashboard.reading-history');

    // Analytics
    Route::get('/analytics/books', [DashboardController::class, 'booksAnalytics'])->name('dashboard.books-analytics');
    Route::get('/analytics/genres', [DashboardController::class, 'genresAnalytics'])->name('dashboard.genres-analytics');
    Route::get('/analytics/authors', [DashboardController::class, 'authorsAnalytics'])->name('dashboard.authors-analytics');
    Route::get('/analytics/reading-time', [DashboardController::class, 'readingTimeAnalytics'])->name('dashboard.reading-time-analytics');

    // Achievements
    Route::get('/achievements', [DashboardController::class, 'achievements'])->name('dashboard.achievements');
    Route::get('/badges', [DashboardController::class, 'badges'])->name('dashboard.badges');
    Route::get('/milestones', [DashboardController::class, 'milestones'])->name('dashboard.milestones');

    // Activity summary
    Route::get('/activity-summary', [DashboardController::class, 'activitySummary'])->name('dashboard.activity-summary');
    Route::get('/activity-chart', [DashboardController::class, 'activityChart'])->name('dashboard.activity-chart');

    // Social stats
    Route::get('/social-stats', [DashboardController::class, 'socialStats'])->name('dashboard.social-stats');
    Route::get('/followers-growth', [DashboardController::class, 'followersGrowth'])->name('dashboard.followers-growth');
    Route::get('/engagement', [DashboardController::class, 'engagement'])->name('dashboard.engagement');

    // Quick actions
    Route::get('/quick-actions', [DashboardController::class, 'quickActions'])->name('dashboard.quick-actions');
    Route::get('/widgets', [DashboardController::class, 'widgets'])->name('dashboard.widgets');

    // Export
    Route::post('/export', [DashboardController::class, 'export'])->name('dashboard.export');
});
