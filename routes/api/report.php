<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('reports')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');

    // Filtering by status (static routes must come before dynamic parameters)
    Route::get('/pending', [ReportController::class, 'pending'])->name('reports.pending');
    Route::get('/reviewed', [ReportController::class, 'reviewed'])->name('reports.reviewed');
    Route::get('/resolved', [ReportController::class, 'resolved'])->name('reports.resolved');
    Route::get('/dismissed', [ReportController::class, 'dismissed'])->name('reports.dismissed');

    // Filtering by type
    Route::get('/type/{type}', [ReportController::class, 'byType'])->name('reports.by-type');

    Route::get('/{report}', [ReportController::class, 'show'])->name('reports.show');

    // Relations
    Route::get('/{report}/reporter', [ReportController::class, 'reporter'])->name('reports.reporter');
    Route::get('/{report}/reportable', [ReportController::class, 'reportable'])->name('reports.reportable');

    Route::post('/', [ReportController::class, 'store'])->name('reports.store');
    Route::put('/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

    // Status actions
    Route::put('/{report}/review', [ReportController::class, 'markReviewed'])->name('reports.review');
    Route::put('/{report}/resolve', [ReportController::class, 'resolve'])->name('reports.resolve');
    Route::put('/{report}/dismiss', [ReportController::class, 'dismiss'])->name('reports.dismiss');
});
