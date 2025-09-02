<?php

namespace App\Actions\AuthorAnswers;

use App\DTOs\AuthorAnswer\AuthorAnswerStoreDTO;
use App\Models\AuthorAnswer;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAuthorAnswer
{
    use AsAction;

    /**
     * Створити нову відповідь автора.
     *
     * @param AuthorAnswerStoreDTO $dto
     * @return AuthorAnswer
     */
    public function handle(AuthorAnswerStoreDTO $dto): AuthorAnswer
    {
        $authorAnswer = new AuthorAnswer();
        $authorAnswer->question_id = $dto->questionId;
        $authorAnswer->author_id = $dto->authorId;
        $authorAnswer->content = $dto->content;
        $authorAnswer->published_at = $dto->publishedAt;
        $authorAnswer->status = $dto->status;

        $authorAnswer->save();

        return $authorAnswer->load(['question', 'author']);
    }
}
