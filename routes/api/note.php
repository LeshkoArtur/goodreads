<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::prefix('notes')->group(function () {
    Route::get('/', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/{note}', [NoteController::class, 'show'])->name('notes.show');

    // Relations
    Route::get('/{note}/user', [NoteController::class, 'user'])->name('notes.user');
    Route::get('/{note}/book', [NoteController::class, 'book'])->name('notes.book');
    Route::get('/{note}/user-book', [NoteController::class, 'userBook'])->name('notes.user-book');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [NoteController::class, 'store'])->name('notes.store');
        Route::put('/{note}', [NoteController::class, 'update'])->name('notes.update');
        Route::delete('/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

        // Actions
        Route::post('/{note}/share', [NoteController::class, 'share'])->name('notes.share');
        Route::post('/{note}/make-private', [NoteController::class, 'makePrivate'])->name('notes.make-private');
    });
});
