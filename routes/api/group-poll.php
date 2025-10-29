<?php

use App\Http\Controllers\GroupPollController;
use Illuminate\Support\Facades\Route;

Route::prefix('group-polls')->group(function () {
    Route::get('/', [GroupPollController::class, 'index'])->name('group-polls.index');
    Route::get('/{groupPoll}', [GroupPollController::class, 'show'])->name('group-polls.show');

    // Relations
    Route::get('/{groupPoll}/group', [GroupPollController::class, 'group'])->name('group-polls.group');
    Route::get('/{groupPoll}/options', [GroupPollController::class, 'options'])->name('group-polls.options');
    Route::get('/{groupPoll}/votes', [GroupPollController::class, 'votes'])->name('group-polls.votes');
    Route::get('/{groupPoll}/results', [GroupPollController::class, 'results'])->name('group-polls.results');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [GroupPollController::class, 'store'])->name('group-polls.store');
        Route::put('/{groupPoll}', [GroupPollController::class, 'update'])->name('group-polls.update');
        Route::delete('/{groupPoll}', [GroupPollController::class, 'destroy'])->name('group-polls.destroy');

        // Voting
        Route::post('/{groupPoll}/vote', [GroupPollController::class, 'vote'])->name('group-polls.vote');
        Route::delete('/{groupPoll}/vote', [GroupPollController::class, 'unvote'])->name('group-polls.unvote');
    });
});
