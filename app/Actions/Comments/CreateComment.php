<?php

namespace App\Actions\Comments;

use App\DTOs\Comment\CommentStoreDTO;
use App\Models\Comment;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateComment
{
    use AsAction;

    /**
     * Створити новий коментар.
     *
     * @param CommentStoreDTO $dto
     * @return Comment
     */
    public function handle(CommentStoreDTO $dto): Comment
    {
        $comment = new Comment();
        $comment->user_id = $dto->userId;
        $comment->commentable_type = $dto->commentableType;
        $comment->commentable_id = $dto->commentableId;
        $comment->content = $dto->content;
        $comment->parent_id = $dto->parentId;

        $comment->save();

        return $comment->load(['user', 'commentable', 'replies', 'parent', 'moderationLogs']);
    }
}
