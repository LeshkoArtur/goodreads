<?php

namespace App\Actions\Authors;

use App\Data\Author\AuthorRelationIndexData;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorQuestions
{
    use AsAction;

    public function handle(Author $author, AuthorRelationIndexData $data): LengthAwarePaginator
    {
        return $author->questions()
            ->with(['user', 'answers'])
            ->withCount('answers')
            ->latest()
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
