<?php

use App\Http\Controllers\EventRsvpController;
use Illuminate\Support\Facades\Route;

Route::prefix('event-rsvps')->group(function () {
    Route::get('/', [EventRsvpController::class, 'index'])->name('event-rsvps.index');
    Route::get('/{eventRsvp}', [EventRsvpController::class, 'show'])->name('event-rsvps.show');

    // Relations
    Route::get('/{eventRsvp}/event', [EventRsvpController::class, 'event'])->name('event-rsvps.event');
    Route::get('/{eventRsvp}/user', [EventRsvpController::class, 'user'])->name('event-rsvps.user');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [EventRsvpController::class, 'store'])->name('event-rsvps.store');
        Route::put('/{eventRsvp}', [EventRsvpController::class, 'update'])->name('event-rsvps.update');
        Route::delete('/{eventRsvp}', [EventRsvpController::class, 'destroy'])->name('event-rsvps.destroy');

        // Response actions
        Route::put('/{eventRsvp}/going', [EventRsvpController::class, 'markGoing'])->name('event-rsvps.going');
        Route::put('/{eventRsvp}/not-going', [EventRsvpController::class, 'markNotGoing'])->name('event-rsvps.not-going');
        Route::put('/{eventRsvp}/maybe', [EventRsvpController::class, 'markMaybe'])->name('event-rsvps.maybe');
    });
});
