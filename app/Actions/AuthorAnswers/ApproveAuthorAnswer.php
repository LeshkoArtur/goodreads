<?php

namespace App\Actions\AuthorAnswers;

use App\Enums\AnswerStatus;
use App\Models\AuthorAnswer;
use Lorisleiva\Actions\Concerns\AsAction;

class ApproveAuthorAnswer
{
    use AsAction;

    public function handle(AuthorAnswer $authorAnswer): AuthorAnswer
    {
        $authorAnswer->status = AnswerStatus::PUBLISHED;
        $authorAnswer->published_at = now();
        $authorAnswer->save();

        return $authorAnswer->fresh(['question', 'author']);
    }
}
