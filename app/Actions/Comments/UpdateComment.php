<?php

namespace App\Actions\Comments;

use App\DTOs\Comment\CommentUpdateDTO;
use App\Models\Comment;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateComment
{
    use AsAction;

    /**
     * Оновити існуючий коментар.
     *
     * @param Comment $comment
     * @param CommentUpdateDTO $dto
     * @return Comment
     */
    public function handle(Comment $comment, CommentUpdateDTO $dto): Comment
    {
        $attributes = [
            'content' => $dto->body,
        ];

        $comment->fill(array_filter($attributes, fn($value) => $value !== null));

        $comment->save();

        return $comment->load(['user', 'commentable', 'replies', 'parent', 'moderationLogs']);
    }
}
