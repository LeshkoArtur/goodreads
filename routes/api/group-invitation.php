<?php

use App\Http\Controllers\GroupInvitationController;
use Illuminate\Support\Facades\Route;

Route::prefix('group-invitations')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [GroupInvitationController::class, 'index'])->name('group-invitations.index');

    // Filtering (static routes must come before dynamic parameters)
    Route::get('/pending', [GroupInvitationController::class, 'pending'])->name('group-invitations.pending');
    Route::get('/sent', [GroupInvitationController::class, 'sent'])->name('group-invitations.sent');
    Route::get('/received', [GroupInvitationController::class, 'received'])->name('group-invitations.received');

    Route::get('/{groupInvitation}', [GroupInvitationController::class, 'show'])->name('group-invitations.show');

    // Relations
    Route::get('/{groupInvitation}/group', [GroupInvitationController::class, 'group'])->name('group-invitations.group');
    Route::get('/{groupInvitation}/inviter', [GroupInvitationController::class, 'inviter'])->name('group-invitations.inviter');
    Route::get('/{groupInvitation}/invitee', [GroupInvitationController::class, 'invitee'])->name('group-invitations.invitee');

    Route::post('/', [GroupInvitationController::class, 'store'])->name('group-invitations.store');
    Route::put('/{groupInvitation}/accept', [GroupInvitationController::class, 'accept'])->name('group-invitations.accept');
    Route::put('/{groupInvitation}/reject', [GroupInvitationController::class, 'reject'])->name('group-invitations.reject');
    Route::delete('/{groupInvitation}', [GroupInvitationController::class, 'destroy'])->name('group-invitations.destroy');

    // Bulk actions
    Route::post('/bulk-accept', [GroupInvitationController::class, 'bulkAccept'])->name('group-invitations.bulk-accept');
    Route::post('/bulk-reject', [GroupInvitationController::class, 'bulkReject'])->name('group-invitations.bulk-reject');
});
