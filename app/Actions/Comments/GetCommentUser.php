<?php

namespace App\Actions\Comments;

use App\Models\Comment;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCommentUser
{
    use AsAction;

    public function handle(Comment $comment): User
    {
        return $comment->user;
    }
}
