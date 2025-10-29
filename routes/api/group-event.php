<?php

use App\Http\Controllers\GroupEventController;
use Illuminate\Support\Facades\Route;

Route::prefix('group-events')->group(function () {
    Route::get('/', [GroupEventController::class, 'index'])->name('group-events.index');
    Route::get('/{groupEvent}', [GroupEventController::class, 'show'])->name('group-events.show');

    // Relations
    Route::get('/{groupEvent}/group', [GroupEventController::class, 'group'])->name('group-events.group');
    Route::get('/{groupEvent}/rsvps', [GroupEventController::class, 'rsvps'])->name('group-events.rsvps');
    Route::get('/{groupEvent}/attendees', [GroupEventController::class, 'attendees'])->name('group-events.attendees');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [GroupEventController::class, 'store'])->name('group-events.store');
        Route::put('/{groupEvent}', [GroupEventController::class, 'update'])->name('group-events.update');
        Route::delete('/{groupEvent}', [GroupEventController::class, 'destroy'])->name('group-events.destroy');

        // RSVP actions
        Route::post('/{groupEvent}/rsvp', [GroupEventController::class, 'rsvp'])->name('group-events.rsvp');
        Route::delete('/{groupEvent}/rsvp', [GroupEventController::class, 'cancelRsvp'])->name('group-events.cancel-rsvp');
    });
});
