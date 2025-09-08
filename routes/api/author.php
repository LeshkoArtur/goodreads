<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/{author}', [AuthorController::class, 'show'])->name('authors.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
        Route::put('/{author}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    });
});

