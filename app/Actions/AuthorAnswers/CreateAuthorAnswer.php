<?php

namespace App\Actions\AuthorAnswers;

use App\Data\AuthorAnswer\AuthorAnswerStoreData;
use App\Models\AuthorAnswer;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAuthorAnswer
{
    use AsAction;

    public function handle(AuthorAnswerStoreData $data): AuthorAnswer
    {
        $authorAnswer = new AuthorAnswer;
        $authorAnswer->question_id = $data->question_id;
        $authorAnswer->author_id = $data->author_id;
        $authorAnswer->content = $data->content;
        $authorAnswer->published_at = $data->published_at;
        $authorAnswer->status = $data->status;
        $authorAnswer->save();

        return $authorAnswer->fresh(['question', 'author']);
    }
}
