<?php

namespace App\Actions\Books;

use App\Data\Book\BookRelationIndexData;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookCollections
{
    use AsAction;

    public function handle(Book $book, BookRelationIndexData $data): LengthAwarePaginator
    {
        return $book->collections()
            ->with(['user'])
            ->withCount('books')
            ->withPivot('order_index')
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
