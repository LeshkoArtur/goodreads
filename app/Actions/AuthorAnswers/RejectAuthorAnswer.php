<?php

namespace App\Actions\AuthorAnswers;

use App\Enums\AnswerStatus;
use App\Models\AuthorAnswer;
use Lorisleiva\Actions\Concerns\AsAction;

class RejectAuthorAnswer
{
    use AsAction;

    public function handle(AuthorAnswer $authorAnswer): AuthorAnswer
    {
        $authorAnswer->status = AnswerStatus::REJECTED;
        $authorAnswer->save();

        return $authorAnswer->fresh(['question', 'author']);
    }
}
