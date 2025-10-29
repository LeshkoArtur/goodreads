<?php

namespace App\Actions\AuthorAnswers;

use App\Data\AuthorAnswer\AuthorAnswerUpdateData;
use App\Models\AuthorAnswer;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAuthorAnswer
{
    use AsAction;

    public function handle(AuthorAnswer $authorAnswer, AuthorAnswerUpdateData $data): AuthorAnswer
    {
        $authorAnswer->update(array_filter([
            'question_id' => $data->question_id,
            'author_id' => $data->author_id,
            'content' => $data->content,
            'published_at' => $data->published_at,
            'status' => $data->status,
        ], fn ($value) => $value !== null));

        return $authorAnswer->fresh(['question', 'author']);
    }
}
