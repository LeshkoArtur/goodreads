<?php

namespace App\Actions\Authors;

use App\Data\Author\AuthorRelationIndexData;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorPosts
{
    use AsAction;

    public function handle(Author $author, AuthorRelationIndexData $data): LengthAwarePaginator
    {
        return $author->posts()
            ->with(['user', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
