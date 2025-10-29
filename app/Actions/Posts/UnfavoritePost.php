<?php

namespace App\Actions\Posts;

use App\Models\Post;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnfavoritePost
{
    use AsAction;

    public function handle(Post $post, User $user): bool
    {
        $favorite = $post->favorites()->where('user_id', $user->id)->first();

        if (! $favorite) {
            return false;
        }

        $favorite->delete();

        return true;
    }
}
