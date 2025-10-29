<?php

namespace App\Actions\AuthorQuestions;

use App\Data\AuthorQuestion\AuthorQuestionRelationIndexData;
use App\Models\AuthorQuestion;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetAuthorQuestionAnswers
{
    use AsAction;

    public function handle(AuthorQuestion $authorQuestion, AuthorQuestionRelationIndexData $data): LengthAwarePaginator
    {
        return $authorQuestion->answers()
            ->with(['user', 'question'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
