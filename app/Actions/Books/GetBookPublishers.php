<?php

namespace App\Actions\Books;

use App\Data\Book\BookRelationIndexData;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookPublishers
{
    use AsAction;

    public function handle(Book $book, BookRelationIndexData $data): LengthAwarePaginator
    {
        return $book->publishers()
            ->withPivot([
                'published_date',
                'isbn',
                'circulation',
                'format',
                'cover_type',
                'translator',
                'edition',
                'price',
                'binding',
            ])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
