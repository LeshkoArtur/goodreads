<?php

use App\Http\Controllers\ChallengeController;
use Illuminate\Support\Facades\Route;

Route::prefix('challenges')->group(function () {
    // Challenges list
    Route::get('/', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::get('/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');
    Route::get('/active', [ChallengeController::class, 'active'])->name('challenges.active');
    Route::get('/upcoming', [ChallengeController::class, 'upcoming'])->name('challenges.upcoming');
    Route::get('/completed', [ChallengeController::class, 'completed'])->name('challenges.completed');

    // Challenge leaderboard
    Route::get('/{challenge}/leaderboard', [ChallengeController::class, 'leaderboard'])->name('challenges.leaderboard');
    Route::get('/{challenge}/participants', [ChallengeController::class, 'participants'])->name('challenges.participants');

    Route::middleware('auth:sanctum')->group(function () {
        // User challenges
        Route::get('/my/active', [ChallengeController::class, 'myActive'])->name('challenges.my-active');
        Route::get('/my/completed', [ChallengeController::class, 'myCompleted'])->name('challenges.my-completed');
        Route::get('/my/progress', [ChallengeController::class, 'myProgress'])->name('challenges.my-progress');

        // Challenge management
        Route::post('/', [ChallengeController::class, 'store'])->name('challenges.store');
        Route::put('/{challenge}', [ChallengeController::class, 'update'])->name('challenges.update');
        Route::delete('/{challenge}', [ChallengeController::class, 'destroy'])->name('challenges.destroy');

        // Join/Leave
        Route::post('/{challenge}/join', [ChallengeController::class, 'join'])->name('challenges.join');
        Route::delete('/{challenge}/leave', [ChallengeController::class, 'leave'])->name('challenges.leave');

        // Progress tracking
        Route::post('/{challenge}/progress', [ChallengeController::class, 'updateProgress'])->name('challenges.update-progress');
        Route::post('/{challenge}/log-book', [ChallengeController::class, 'logBook'])->name('challenges.log-book');

        // Reading Challenge (Annual)
        Route::get('/reading-challenge/current', [ChallengeController::class, 'currentReadingChallenge'])->name('challenges.current-reading-challenge');
        Route::post('/reading-challenge/set-goal', [ChallengeController::class, 'setReadingGoal'])->name('challenges.set-reading-goal');
        Route::put('/reading-challenge/update-goal', [ChallengeController::class, 'updateReadingGoal'])->name('challenges.update-reading-goal');
        Route::get('/reading-challenge/progress', [ChallengeController::class, 'readingChallengeProgress'])->name('challenges.reading-challenge-progress');
    });
});
