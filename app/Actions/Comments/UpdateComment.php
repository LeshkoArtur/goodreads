<?php

namespace App\Actions\Comments;

use App\Data\Comment\CommentUpdateData;
use App\Models\Comment;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateComment
{
    use AsAction;

    public function handle(Comment $comment, CommentUpdateData $data): Comment
    {
        $comment->content = $data->content;
        $comment->save();

        return $comment->fresh(['user', 'commentable']);
    }
}
