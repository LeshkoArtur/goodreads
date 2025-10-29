<?php

namespace App\Actions\GroupPosts;

use App\Models\GroupPost;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class LikeGroupPost
{
    use AsAction;

    public function handle(GroupPost $groupPost, User $user): bool
    {
        $exists = $groupPost->likes()
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            return false;
        }

        $groupPost->likes()->create([
            'user_id' => $user->id,
        ]);

        return true;
    }
}
