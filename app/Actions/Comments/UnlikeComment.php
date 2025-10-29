<?php

namespace App\Actions\Comments;

use App\Models\Comment;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnlikeComment
{
    use AsAction;

    public function handle(Comment $comment, User $user): bool
    {
        $deleted = $comment->likes()
            ->where('user_id', $user->id)
            ->delete();

        return $deleted > 0;
    }
}
