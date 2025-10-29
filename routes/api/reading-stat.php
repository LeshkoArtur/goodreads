<?php

use App\Http\Controllers\ReadingStatController;
use Illuminate\Support\Facades\Route;

Route::prefix('reading-stats')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ReadingStatController::class, 'index'])->name('reading-stats.index');

    // Analytics (static routes must come before dynamic parameters)
    Route::get('/user/{user}/yearly', [ReadingStatController::class, 'yearlyStats'])->name('reading-stats.yearly');
    Route::get('/user/{user}/monthly', [ReadingStatController::class, 'monthlyStats'])->name('reading-stats.monthly');
    Route::get('/user/{user}/summary', [ReadingStatController::class, 'summary'])->name('reading-stats.summary');

    Route::get('/{readingStat}', [ReadingStatController::class, 'show'])->name('reading-stats.show');

    // Relations
    Route::get('/{readingStat}/user', [ReadingStatController::class, 'user'])->name('reading-stats.user');
    Route::get('/{readingStat}/book', [ReadingStatController::class, 'book'])->name('reading-stats.book');

    Route::post('/', [ReadingStatController::class, 'store'])->name('reading-stats.store');
    Route::put('/{readingStat}', [ReadingStatController::class, 'update'])->name('reading-stats.update');
    Route::delete('/{readingStat}', [ReadingStatController::class, 'destroy'])->name('reading-stats.destroy');

    // Tracking
    Route::post('/track-session', [ReadingStatController::class, 'trackSession'])->name('reading-stats.track-session');
});
