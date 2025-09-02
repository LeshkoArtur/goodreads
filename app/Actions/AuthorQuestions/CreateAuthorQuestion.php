<?php

namespace App\Actions\AuthorQuestions;

use App\DTOs\AuthorQuestion\AuthorQuestionStoreDTO;
use App\Models\AuthorQuestion;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAuthorQuestion
{
    use AsAction;

    /**
     * Створити нове питання до автора.
     *
     * @param AuthorQuestionStoreDTO $dto
     * @return AuthorQuestion
     */
    public function handle(AuthorQuestionStoreDTO $dto): AuthorQuestion
    {
        $authorQuestion = new AuthorQuestion();
        $authorQuestion->user_id = $dto->userId;
        $authorQuestion->author_id = $dto->authorId;
        $authorQuestion->book_id = $dto->bookId;
        $authorQuestion->content = $dto->content;
        $authorQuestion->status = $dto->status;

        $authorQuestion->save();

        return $authorQuestion->load(['user', 'author', 'book', 'answers']);
    }
}
