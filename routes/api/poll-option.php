<?php

use App\Http\Controllers\PollOptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('poll-options')->group(function () {
    Route::get('/', [PollOptionController::class, 'index'])->name('poll-options.index');
    Route::get('/{pollOption}', [PollOptionController::class, 'show'])->name('poll-options.show');

    // Relations
    Route::get('/{pollOption}/poll', [PollOptionController::class, 'poll'])->name('poll-options.poll');
    Route::get('/{pollOption}/votes', [PollOptionController::class, 'votes'])->name('poll-options.votes');

    // Stats
    Route::get('/{pollOption}/vote-count', [PollOptionController::class, 'voteCount'])->name('poll-options.vote-count');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [PollOptionController::class, 'store'])->name('poll-options.store');
        Route::put('/{pollOption}', [PollOptionController::class, 'update'])->name('poll-options.update');
        Route::delete('/{pollOption}', [PollOptionController::class, 'destroy'])->name('poll-options.destroy');
    });
});
