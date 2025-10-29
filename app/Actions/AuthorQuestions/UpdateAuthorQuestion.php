<?php

namespace App\Actions\AuthorQuestions;

use App\Data\AuthorQuestion\AuthorQuestionUpdateData;
use App\Models\AuthorQuestion;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateAuthorQuestion
{
    use AsAction;

    public function handle(AuthorQuestion $authorQuestion, AuthorQuestionUpdateData $data): AuthorQuestion
    {
        $authorQuestion->update(array_filter([
            'user_id' => $data->user_id,
            'author_id' => $data->author_id,
            'content' => $data->content,
            'book_id' => $data->book_id,
            'status' => $data->status,
        ], fn ($value) => $value !== null));

        return $authorQuestion->fresh(['user', 'author', 'book', 'answers']);
    }
}
