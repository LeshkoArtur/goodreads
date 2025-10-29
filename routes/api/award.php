<?php

use App\Http\Controllers\AwardController;
use Illuminate\Support\Facades\Route;

Route::prefix('awards')->group(function () {
    Route::get('/', [AwardController::class, 'index'])->name('awards.index');
    Route::get('/{award}', [AwardController::class, 'show'])->name('awards.show');

    // Relations
    Route::get('/{award}/nominations', [AwardController::class, 'nominations'])->name('awards.nominations');
    Route::get('/{award}/entries', [AwardController::class, 'entries'])->name('awards.entries');
    Route::get('/{award}/winners', [AwardController::class, 'winners'])->name('awards.winners');

    // Stats
    Route::get('/{award}/stats', [AwardController::class, 'stats'])->name('awards.stats');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [AwardController::class, 'store'])->name('awards.store');
        Route::put('/{award}', [AwardController::class, 'update'])->name('awards.update');
        Route::delete('/{award}', [AwardController::class, 'destroy'])->name('awards.destroy');
    });
});
