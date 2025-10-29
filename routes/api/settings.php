<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->middleware('auth:sanctum')->group(function () {
    // General settings
    Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/', [SettingsController::class, 'update'])->name('settings.update');

    // Account settings
    Route::get('/account', [SettingsController::class, 'account'])->name('settings.account');
    Route::put('/account', [SettingsController::class, 'updateAccount'])->name('settings.update-account');
    Route::put('/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
    Route::put('/email', [SettingsController::class, 'updateEmail'])->name('settings.update-email');

    // Privacy settings
    Route::get('/privacy', [SettingsController::class, 'privacy'])->name('settings.privacy');
    Route::put('/privacy', [SettingsController::class, 'updatePrivacy'])->name('settings.update-privacy');
    Route::put('/privacy/profile-visibility', [SettingsController::class, 'updateProfileVisibility'])->name('settings.profile-visibility');
    Route::put('/privacy/reading-activity', [SettingsController::class, 'updateReadingActivity'])->name('settings.reading-activity');

    // Notification preferences
    Route::get('/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::put('/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.update-notifications');
    Route::put('/notifications/email', [SettingsController::class, 'updateEmailNotifications'])->name('settings.email-notifications');
    Route::put('/notifications/push', [SettingsController::class, 'updatePushNotifications'])->name('settings.push-notifications');

    // Reading preferences
    Route::get('/reading', [SettingsController::class, 'reading'])->name('settings.reading');
    Route::put('/reading', [SettingsController::class, 'updateReading'])->name('settings.update-reading');
    Route::put('/reading/default-shelf', [SettingsController::class, 'updateDefaultShelf'])->name('settings.default-shelf');
    Route::put('/reading/challenge', [SettingsController::class, 'updateReadingChallenge'])->name('settings.reading-challenge');

    // Display preferences
    Route::get('/display', [SettingsController::class, 'display'])->name('settings.display');
    Route::put('/display', [SettingsController::class, 'updateDisplay'])->name('settings.update-display');
    Route::put('/display/theme', [SettingsController::class, 'updateTheme'])->name('settings.theme');
    Route::put('/display/language', [SettingsController::class, 'updateLanguage'])->name('settings.language');

    // Data management
    Route::get('/data', [SettingsController::class, 'data'])->name('settings.data');
    Route::post('/data/export', [SettingsController::class, 'exportData'])->name('settings.export-data');
    Route::post('/data/import', [SettingsController::class, 'importData'])->name('settings.import-data');
    Route::delete('/data/delete-account', [SettingsController::class, 'deleteAccount'])->name('settings.delete-account');

    // Connected accounts
    Route::get('/connected-accounts', [SettingsController::class, 'connectedAccounts'])->name('settings.connected-accounts');
    Route::post('/connected-accounts/{provider}', [SettingsController::class, 'connectAccount'])->name('settings.connect-account');
    Route::delete('/connected-accounts/{provider}', [SettingsController::class, 'disconnectAccount'])->name('settings.disconnect-account');

    // Blocked users
    Route::get('/blocked-users', [SettingsController::class, 'blockedUsers'])->name('settings.blocked-users');
    Route::post('/blocked-users/{user}', [SettingsController::class, 'blockUser'])->name('settings.block-user');
    Route::delete('/blocked-users/{user}', [SettingsController::class, 'unblockUser'])->name('settings.unblock-user');
});
