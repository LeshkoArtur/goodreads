<?php

namespace App\Actions\Comments;

use App\Data\Comment\CommentStoreData;
use App\Models\Comment;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateComment
{
    use AsAction;

    public function handle(CommentStoreData $data, User $user): Comment
    {
        $comment = new Comment;
        $comment->user_id = $user->id;
        $comment->content = $data->content;
        $comment->commentable_type = $data->commentable_type;
        $comment->commentable_id = $data->commentable_id;
        $comment->parent_id = $data->parent_id;
        $comment->save();

        return $comment->fresh(['user', 'commentable']);
    }
}
