<?php

namespace App\Actions\Posts;

use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class FavoritePost
{
    use AsAction;

    public function handle(Post $post, User $user): bool
    {
        if ($post->favorites()->where('user_id', $user->id)->exists()) {
            return false;
        }

        Favorite::create([
            'user_id' => $user->id,
            'favoriteable_type' => Post::class,
            'favoriteable_id' => $post->id,
        ]);

        return true;
    }
}
