<?php

namespace App\Actions\Authors;

use App\Data\Author\AuthorRelationIndexData;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorBooks
{
    use AsAction;

    public function handle(Author $author, AuthorRelationIndexData $data): LengthAwarePaginator
    {
        return $author->books()
            ->with(['authors', 'genres', 'publishers'])
            ->withCount(['ratings', 'reviews'])
            ->withAvg('ratings', 'value')
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
