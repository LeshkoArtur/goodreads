<?php

namespace App\Actions\Posts;

use App\Models\Post;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnlikePost
{
    use AsAction;

    public function handle(Post $post, User $user): bool
    {
        $like = $post->likes()->where('user_id', $user->id)->first();

        if (! $like) {
            return false;
        }

        $like->delete();

        return true;
    }
}
