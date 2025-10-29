<?php

use App\Http\Controllers\NominationController;
use Illuminate\Support\Facades\Route;

Route::prefix('nominations')->group(function () {
    Route::get('/', [NominationController::class, 'index'])->name('nominations.index');
    Route::get('/{nomination}', [NominationController::class, 'show'])->name('nominations.show');

    // Relations
    Route::get('/{nomination}/award', [NominationController::class, 'award'])->name('nominations.award');
    Route::get('/{nomination}/entries', [NominationController::class, 'entries'])->name('nominations.entries');
    Route::get('/{nomination}/creator', [NominationController::class, 'creator'])->name('nominations.creator');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [NominationController::class, 'store'])->name('nominations.store');
        Route::put('/{nomination}', [NominationController::class, 'update'])->name('nominations.update');
        Route::delete('/{nomination}', [NominationController::class, 'destroy'])->name('nominations.destroy');

        // Voting
        Route::post('/{nomination}/vote/{entry}', [NominationController::class, 'vote'])->name('nominations.vote');
    });
});
