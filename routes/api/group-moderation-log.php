<?php

use App\Http\Controllers\GroupModerationLogController;
use Illuminate\Support\Facades\Route;

Route::prefix('group-moderation-logs')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [GroupModerationLogController::class, 'index'])->name('group-moderation-logs.index');

    // Filtering (static routes must come before dynamic parameters)
    Route::get('/group/{group}', [GroupModerationLogController::class, 'byGroup'])->name('group-moderation-logs.by-group');
    Route::get('/moderator/{user}', [GroupModerationLogController::class, 'byModerator'])->name('group-moderation-logs.by-moderator');
    Route::get('/subject/{user}', [GroupModerationLogController::class, 'bySubject'])->name('group-moderation-logs.by-subject');

    Route::get('/{groupModerationLog}', [GroupModerationLogController::class, 'show'])->name('group-moderation-logs.show');

    // Relations
    Route::get('/{groupModerationLog}/group', [GroupModerationLogController::class, 'group'])->name('group-moderation-logs.group');
    Route::get('/{groupModerationLog}/moderator', [GroupModerationLogController::class, 'moderator'])->name('group-moderation-logs.moderator');
    Route::get('/{groupModerationLog}/subject', [GroupModerationLogController::class, 'subject'])->name('group-moderation-logs.subject');

    Route::post('/', [GroupModerationLogController::class, 'store'])->name('group-moderation-logs.store');
});
