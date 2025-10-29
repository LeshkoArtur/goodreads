<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('books.index');
    Route::get('/{book}', [BookController::class, 'show'])->name('books.show');

    // Relations
    Route::get('/{book}/authors', [BookController::class, 'authors'])->name('books.authors');
    Route::get('/{book}/genres', [BookController::class, 'genres'])->name('books.genres');
    Route::get('/{book}/publishers', [BookController::class, 'publishers'])->name('books.publishers');
    Route::get('/{book}/series', [BookController::class, 'series'])->name('books.series');
    Route::get('/{book}/series-books', [BookController::class, 'seriesBooks'])->name('books.series-books');

    // Content
    Route::get('/{book}/characters', [BookController::class, 'characters'])->name('books.characters');
    Route::get('/{book}/quotes', [BookController::class, 'quotes'])->name('books.quotes');
    Route::get('/{book}/ratings', [BookController::class, 'ratings'])->name('books.ratings');
    Route::get('/{book}/reviews', [BookController::class, 'reviews'])->name('books.reviews');

    // Social
    Route::get('/{book}/posts', [BookController::class, 'posts'])->name('books.posts');
    Route::get('/{book}/discussions', [BookController::class, 'discussions'])->name('books.discussions');
    Route::get('/{book}/questions', [BookController::class, 'questions'])->name('books.questions');

    // Stats & Discovery
    Route::get('/{book}/stats', [BookController::class, 'stats'])->name('books.stats');
    Route::get('/{book}/similar', [BookController::class, 'similar'])->name('books.similar');
    Route::get('/{book}/offers', [BookController::class, 'offers'])->name('books.offers');

    // Collections
    Route::get('/{book}/collections', [BookController::class, 'collections'])->name('books.collections');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');

        // Manage relations
        Route::post('/{book}/authors/{author}', [BookController::class, 'attachAuthor'])->name('books.authors.attach');
        Route::delete('/{book}/authors/{author}', [BookController::class, 'detachAuthor'])->name('books.authors.detach');
        Route::post('/{book}/genres/{genre}', [BookController::class, 'attachGenre'])->name('books.genres.attach');
        Route::delete('/{book}/genres/{genre}', [BookController::class, 'detachGenre'])->name('books.genres.detach');
        Route::post('/{book}/publishers/{publisher}', [BookController::class, 'attachPublisher'])->name('books.publishers.attach');
        Route::delete('/{book}/publishers/{publisher}', [BookController::class, 'detachPublisher'])->name('books.publishers.detach');

        // User actions
        Route::post('/{book}/mark-as-read', [BookController::class, 'markAsRead'])->name('books.mark-as-read');
        Route::post('/{book}/mark-as-reading', [BookController::class, 'markAsReading'])->name('books.mark-as-reading');
        Route::post('/{book}/mark-as-want-to-read', [BookController::class, 'markAsWantToRead'])->name('books.mark-as-want-to-read');
        Route::post('/{book}/mark-as-dnf', [BookController::class, 'markAsDNF'])->name('books.mark-as-dnf');
        Route::post('/{book}/mark-as-on-hold', [BookController::class, 'markAsOnHold'])->name('books.mark-as-on-hold');
        Route::post('/{book}/mark-as-favorite', [BookController::class, 'markAsFavorite'])->name('books.mark-as-favorite');
        Route::post('/{book}/mark-as-rereading', [BookController::class, 'markAsRereading'])->name('books.mark-as-rereading');
        Route::post('/{book}/mark-as-owned', [BookController::class, 'markAsOwned'])->name('books.mark-as-owned');
    });
});
