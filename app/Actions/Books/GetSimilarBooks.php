<?php

namespace App\Actions\Books;

use App\Data\Book\BookRelationIndexData;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSimilarBooks
{
    use AsAction;

    public function handle(Book $book, BookRelationIndexData $data): LengthAwarePaginator
    {
        $bookGenreIds = $book->genres()->pluck('genres.id')->toArray();
        $bookAuthorIds = $book->authors()->pluck('authors.id')->toArray();

        return Book::where('id', '!=', $book->id)
            ->where(function ($query) use ($bookGenreIds, $bookAuthorIds, $book) {
                $query->whereHas('genres', function ($q) use ($bookGenreIds) {
                    $q->whereIn('genres.id', $bookGenreIds);
                })
                    ->orWhereHas('authors', function ($q) use ($bookAuthorIds) {
                        $q->whereIn('authors.id', $bookAuthorIds);
                    })
                    ->orWhere('series_id', $book->series_id);
            })
            ->with(['authors', 'genres'])
            ->withCount('ratings')
            ->withAvg('ratings', 'value')
            ->orderByDesc('ratings_count')
            ->paginate(
                perPage: $data->per_page ?? 10,
                page: $data->page ?? 1
            );
    }
}
