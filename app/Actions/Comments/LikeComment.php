<?php

namespace App\Actions\Comments;

use App\Models\Comment;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LikeComment
{
    use AsAction;

    public function handle(Comment $comment, User $user): bool
    {
        $exists = $comment->likes()
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            return false;
        }

        $comment->likes()->create([
            'user_id' => $user->id,
        ]);

        return true;
    }
}
