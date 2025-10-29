<?php

use App\Http\Controllers\PollVoteController;
use Illuminate\Support\Facades\Route;

Route::prefix('poll-votes')->group(function () {
    Route::get('/', [PollVoteController::class, 'index'])->name('poll-votes.index');
    Route::get('/{pollVote}', [PollVoteController::class, 'show'])->name('poll-votes.show');

    // Relations
    Route::get('/{pollVote}/option', [PollVoteController::class, 'option'])->name('poll-votes.option');
    Route::get('/{pollVote}/user', [PollVoteController::class, 'user'])->name('poll-votes.user');
    Route::get('/{pollVote}/poll', [PollVoteController::class, 'poll'])->name('poll-votes.poll');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PollVoteController::class, 'store'])->name('poll-votes.store');
        Route::delete('/{pollVote}', [PollVoteController::class, 'destroy'])->name('poll-votes.destroy');

        // Change vote
        Route::put('/{pollVote}/change-option', [PollVoteController::class, 'changeOption'])->name('poll-votes.change-option');
    });
});
