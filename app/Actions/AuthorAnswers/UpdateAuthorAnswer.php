<?php

namespace App\Actions\AuthorAnswers;

use App\DTOs\AuthorAnswer\AuthorAnswerUpdateDTO;
use App\Models\AuthorAnswer;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAuthorAnswer
{
    use AsAction;

    /**
     * Оновити існуючу відповідь автора.
     *
     * @param AuthorAnswer $authorAnswer
     * @param AuthorAnswerUpdateDTO $dto
     * @return AuthorAnswer
     */
    public function handle(AuthorAnswer $authorAnswer, AuthorAnswerUpdateDTO $dto): AuthorAnswer
    {
        $attributes = [
            'content' => $dto->body,
            'status' => $dto->status,
            'published_at' => $dto->publishedAt,
        ];

        $authorAnswer->fill(array_filter($attributes, fn($value) => $value !== null));

        $authorAnswer->save();

        return $authorAnswer->load(['question', 'author']);
    }
}
