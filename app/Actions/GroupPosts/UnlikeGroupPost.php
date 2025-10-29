<?php

namespace App\Actions\GroupPosts;

use App\Models\GroupPost;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnlikeGroupPost
{
    use AsAction;

    public function handle(GroupPost $groupPost, User $user): bool
    {
        $deleted = $groupPost->likes()
            ->where('user_id', $user->id)
            ->delete();

        return $deleted > 0;
    }
}
