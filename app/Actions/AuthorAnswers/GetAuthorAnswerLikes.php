<?php

namespace App\Actions\AuthorAnswers;

use App\Data\AuthorAnswer\AuthorAnswerRelationIndexData;
use App\Models\AuthorAnswer;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorAnswerLikes
{
    use AsAction;

    public function handle(AuthorAnswer $authorAnswer, AuthorAnswerRelationIndexData $data): LengthAwarePaginator
    {
        return $authorAnswer->likes()
            ->with(['user', 'likeable'])
            ->latest()
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
