<?php

use App\Http\Controllers\NominationEntryController;
use Illuminate\Support\Facades\Route;

Route::prefix('nomination-entries')->group(function () {
    Route::get('/', [NominationEntryController::class, 'index'])->name('nomination-entries.index');
    Route::get('/{nominationEntry}', [NominationEntryController::class, 'show'])->name('nomination-entries.show');

    // Relations
    Route::get('/{nominationEntry}/nomination', [NominationEntryController::class, 'nomination'])->name('nomination-entries.nomination');
    Route::get('/{nominationEntry}/award', [NominationEntryController::class, 'award'])->name('nomination-entries.award');
    Route::get('/{nominationEntry}/book', [NominationEntryController::class, 'book'])->name('nomination-entries.book');
    Route::get('/{nominationEntry}/author', [NominationEntryController::class, 'author'])->name('nomination-entries.author');

    // Stats
    Route::get('/{nominationEntry}/vote-count', [NominationEntryController::class, 'voteCount'])->name('nomination-entries.vote-count');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [NominationEntryController::class, 'store'])->name('nomination-entries.store');
        Route::put('/{nominationEntry}', [NominationEntryController::class, 'update'])->name('nomination-entries.update');
        Route::delete('/{nominationEntry}', [NominationEntryController::class, 'destroy'])->name('nomination-entries.destroy');

        // Status actions
        Route::post('/{nominationEntry}/approve', [NominationEntryController::class, 'approve'])->name('nomination-entries.approve');
        Route::post('/{nominationEntry}/reject', [NominationEntryController::class, 'reject'])->name('nomination-entries.reject');
        Route::post('/{nominationEntry}/mark-winner', [NominationEntryController::class, 'markWinner'])->name('nomination-entries.mark-winner');
    });
});
