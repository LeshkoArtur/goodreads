<?php

namespace App\Actions\AuthorQuestions;

use App\DTOs\AuthorQuestion\AuthorQuestionUpdateDTO;
use App\Models\AuthorQuestion;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAuthorQuestion
{
    use AsAction;

    /**
     * Оновити існуюче питання до автора.
     *
     * @param AuthorQuestion $authorQuestion
     * @param AuthorQuestionUpdateDTO $dto
     * @return AuthorQuestion
     */
    public function handle(AuthorQuestion $authorQuestion, AuthorQuestionUpdateDTO $dto): AuthorQuestion
    {
        $attributes = [
            'content' => $dto->body,
            'status' => $dto->status,
        ];

        $authorQuestion->fill(array_filter($attributes, fn($value) => $value !== null));

        $authorQuestion->save();

        return $authorQuestion->load(['user', 'author', 'book', 'answers']);
    }
}
