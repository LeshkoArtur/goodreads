<?php

namespace App\Actions\Books;

use App\Data\Book\BookRelationIndexData;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookSeriesBooks
{
    use AsAction;

    public function handle(Book $book, BookRelationIndexData $data): LengthAwarePaginator
    {
        if (! $book->series_id) {
            return new LengthAwarePaginator(
                [],
                0,
                $data->per_page ?? 15,
                $data->page ?? 1
            );
        }

        return Book::where('series_id', $book->series_id)
            ->where('id', '!=', $book->id)
            ->with(['authors', 'genres'])
            ->orderBy('number_in_series')
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
