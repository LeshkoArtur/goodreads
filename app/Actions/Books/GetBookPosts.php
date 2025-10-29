<?php

namespace App\Actions\Books;

use App\Data\Book\BookRelationIndexData;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBookPosts
{
    use AsAction;

    public function handle(Book $book, BookRelationIndexData $data): LengthAwarePaginator
    {
        return $book->posts()
            ->with(['user', 'author'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
