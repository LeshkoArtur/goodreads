<?php

namespace App\Actions\Posts;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LikePost
{
    use AsAction;

    public function handle(Post $post, User $user): bool
    {
        if ($post->likes()->where('user_id', $user->id)->exists()) {
            return false;
        }

        Like::create([
            'user_id' => $user->id,
            'likeable_type' => Post::class,
            'likeable_id' => $post->id,
        ]);

        return true;
    }
}
