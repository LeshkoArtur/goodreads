<?php

use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;

Route::prefix('groups')->group(function () {
    Route::get('/', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/{group}', [GroupController::class, 'show'])->name('groups.show');

    // Members
    Route::get('/{group}/members', [GroupController::class, 'members'])->name('groups.members');
    Route::get('/{group}/moderators', [GroupController::class, 'moderators'])->name('groups.moderators');
    Route::get('/{group}/admins', [GroupController::class, 'admins'])->name('groups.admins');

    // Content
    Route::get('/{group}/posts', [GroupController::class, 'posts'])->name('groups.posts');
    Route::get('/{group}/events', [GroupController::class, 'events'])->name('groups.events');
    Route::get('/{group}/polls', [GroupController::class, 'polls'])->name('groups.polls');
    Route::get('/{group}/invitations', [GroupController::class, 'invitations'])->name('groups.invitations');

    // Stats
    Route::get('/{group}/stats', [GroupController::class, 'stats'])->name('groups.stats');
    Route::get('/{group}/activity', [GroupController::class, 'activity'])->name('groups.activity');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [GroupController::class, 'store'])->name('groups.store');
        Route::put('/{group}', [GroupController::class, 'update'])->name('groups.update');
        Route::delete('/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');

        // Membership
        Route::post('/{group}/join', [GroupController::class, 'join'])->name('groups.join');
        Route::post('/{group}/leave', [GroupController::class, 'leave'])->name('groups.leave');
        Route::post('/{group}/invite/{user}', [GroupController::class, 'inviteUser'])->name('groups.invite');
        Route::post('/{group}/remove/{user}', [GroupController::class, 'removeMember'])->name('groups.remove-member');
        Route::put('/{group}/members/{user}/role', [GroupController::class, 'updateMemberRole'])->name('groups.update-member-role');
        Route::post('/{group}/ban/{user}', [GroupController::class, 'banMember'])->name('groups.ban-member');
        Route::delete('/{group}/unban/{user}', [GroupController::class, 'unbanMember'])->name('groups.unban-member');
    });
});
