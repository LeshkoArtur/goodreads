<?php

namespace App\Actions\AuthorQuestions;

use App\Data\AuthorQuestion\AuthorQuestionStoreData;
use App\Models\AuthorQuestion;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAuthorQuestion
{
    use AsAction;

    public function handle(AuthorQuestionStoreData $data): AuthorQuestion
    {
        $authorQuestion = new AuthorQuestion;
        $authorQuestion->user_id = $data->user_id;
        $authorQuestion->author_id = $data->author_id;
        $authorQuestion->content = $data->content;
        $authorQuestion->book_id = $data->book_id;
        $authorQuestion->status = $data->status;
        $authorQuestion->save();

        return $authorQuestion->fresh(['user', 'author', 'book', 'answers']);
    }
}
