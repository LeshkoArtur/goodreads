<?php

use App\Http\Controllers\Admin\AdminContentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminStatisticsController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/overview', [AdminController::class, 'overview'])->name('admin.overview');

    // User management
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
        Route::put('/{user}/suspend', [AdminUserController::class, 'suspend'])->name('admin.users.suspend');
        Route::put('/{user}/unsuspend', [AdminUserController::class, 'unsuspend'])->name('admin.users.unsuspend');
        Route::put('/{user}/ban', [AdminUserController::class, 'ban'])->name('admin.users.ban');
        Route::put('/{user}/unban', [AdminUserController::class, 'unban'])->name('admin.users.unban');
        Route::put('/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.update-role');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/{user}/activity', [AdminUserController::class, 'activity'])->name('admin.users.activity');
        Route::get('/flagged', [AdminUserController::class, 'flagged'])->name('admin.users.flagged');
    });

    // Content moderation
    Route::prefix('content')->group(function () {
        Route::get('/pending', [AdminContentController::class, 'pending'])->name('admin.content.pending');
        Route::get('/flagged', [AdminContentController::class, 'flagged'])->name('admin.content.flagged');
        Route::put('/{type}/{id}/approve', [AdminContentController::class, 'approve'])->name('admin.content.approve');
        Route::put('/{type}/{id}/reject', [AdminContentController::class, 'reject'])->name('admin.content.reject');
        Route::delete('/{type}/{id}', [AdminContentController::class, 'delete'])->name('admin.content.delete');

        // Specific content types
        Route::get('/books', [AdminContentController::class, 'books'])->name('admin.content.books');
        Route::get('/authors', [AdminContentController::class, 'authors'])->name('admin.content.authors');
        Route::get('/reviews', [AdminContentController::class, 'reviews'])->name('admin.content.reviews');
        Route::get('/posts', [AdminContentController::class, 'posts'])->name('admin.content.posts');
        Route::get('/comments', [AdminContentController::class, 'comments'])->name('admin.content.comments');
    });

    // Reports management
    Route::prefix('reports')->group(function () {
        Route::get('/', [AdminReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/{report}', [AdminReportController::class, 'show'])->name('admin.reports.show');
        Route::get('/pending', [AdminReportController::class, 'pending'])->name('admin.reports.pending');
        Route::get('/type/{type}', [AdminReportController::class, 'byType'])->name('admin.reports.by-type');
        Route::put('/{report}/review', [AdminReportController::class, 'review'])->name('admin.reports.review');
        Route::put('/{report}/resolve', [AdminReportController::class, 'resolve'])->name('admin.reports.resolve');
        Route::put('/{report}/dismiss', [AdminReportController::class, 'dismiss'])->name('admin.reports.dismiss');
        Route::post('/{report}/action', [AdminReportController::class, 'takeAction'])->name('admin.reports.action');
    });

    // Statistics
    Route::prefix('statistics')->group(function () {
        Route::get('/', [AdminStatisticsController::class, 'index'])->name('admin.statistics.index');
        Route::get('/users', [AdminStatisticsController::class, 'users'])->name('admin.statistics.users');
        Route::get('/content', [AdminStatisticsController::class, 'content'])->name('admin.statistics.content');
        Route::get('/engagement', [AdminStatisticsController::class, 'engagement'])->name('admin.statistics.engagement');
        Route::get('/growth', [AdminStatisticsController::class, 'growth'])->name('admin.statistics.growth');
        Route::get('/reports-summary', [AdminStatisticsController::class, 'reportsSummary'])->name('admin.statistics.reports-summary');
    });

    // System settings
    Route::prefix('system')->group(function () {
        Route::get('/settings', [AdminController::class, 'systemSettings'])->name('admin.system.settings');
        Route::put('/settings', [AdminController::class, 'updateSystemSettings'])->name('admin.system.update-settings');
        Route::get('/maintenance', [AdminController::class, 'maintenanceMode'])->name('admin.system.maintenance');
        Route::put('/maintenance/toggle', [AdminController::class, 'toggleMaintenance'])->name('admin.system.toggle-maintenance');
        Route::post('/cache/clear', [AdminController::class, 'clearCache'])->name('admin.system.clear-cache');
        Route::get('/logs', [AdminController::class, 'logs'])->name('admin.system.logs');
    });

    // Featured content
    Route::prefix('featured')->group(function () {
        Route::get('/', [AdminController::class, 'featured'])->name('admin.featured.index');
        Route::post('/books/{book}', [AdminController::class, 'featureBook'])->name('admin.featured.book');
        Route::post('/authors/{author}', [AdminController::class, 'featureAuthor'])->name('admin.featured.author');
        Route::delete('/{type}/{id}', [AdminController::class, 'unfeature'])->name('admin.featured.remove');
    });

    // Announcements
    Route::prefix('announcements')->group(function () {
        Route::get('/', [AdminController::class, 'announcements'])->name('admin.announcements.index');
        Route::post('/', [AdminController::class, 'createAnnouncement'])->name('admin.announcements.create');
        Route::put('/{announcement}', [AdminController::class, 'updateAnnouncement'])->name('admin.announcements.update');
        Route::delete('/{announcement}', [AdminController::class, 'deleteAnnouncement'])->name('admin.announcements.delete');
    });
});
