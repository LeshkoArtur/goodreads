<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->middleware('auth:sanctum')->group(function () {
    // Notifications list
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/{notification}', [NotificationController::class, 'show'])->name('notifications.show');

    // Filtering
    Route::get('/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::get('/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::get('/type/{type}', [NotificationController::class, 'byType'])->name('notifications.by-type');

    // Mark actions
    Route::put('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::put('/{notification}/mark-unread', [NotificationController::class, 'markAsUnread'])->name('notifications.mark-unread');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Delete
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/clear-read', [NotificationController::class, 'clearRead'])->name('notifications.clear-read');
    Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');

    // Stats
    Route::get('/count/unread', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/count/total', [NotificationController::class, 'totalCount'])->name('notifications.total-count');

    // Settings
    Route::get('/settings', [NotificationController::class, 'getSettings'])->name('notifications.get-settings');
    Route::put('/settings', [NotificationController::class, 'updateSettings'])->name('notifications.update-settings');
    Route::put('/settings/toggle/{type}', [NotificationController::class, 'toggleType'])->name('notifications.toggle-type');

    // Push notifications
    Route::post('/subscribe', [NotificationController::class, 'subscribe'])->name('notifications.subscribe');
    Route::post('/unsubscribe', [NotificationController::class, 'unsubscribe'])->name('notifications.unsubscribe');
    Route::post('/test', [NotificationController::class, 'sendTest'])->name('notifications.test');
});
