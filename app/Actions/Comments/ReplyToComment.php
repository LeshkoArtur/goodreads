<?php

namespace App\Actions\Comments;

use App\Data\Comment\CommentReplyData;
use App\Models\Comment;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ReplyToComment
{
    use AsAction;

    public function handle(Comment $comment, CommentReplyData $data, User $user): Comment
    {
        $reply = new Comment;
        $reply->user_id = $user->id;
        $reply->content = $data->content;
        $reply->commentable_type = $comment->commentable_type;
        $reply->commentable_id = $comment->commentable_id;
        $reply->parent_id = $comment->id;
        $reply->save();

        return $reply->fresh(['user', 'parent']);
    }
}
