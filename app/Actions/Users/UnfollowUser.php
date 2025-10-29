<?php

namespace App\Actions\Users;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnfollowUser
{
    use AsAction;

    public function handle(User $userToUnfollow, User $follower): bool
    {
        if (! $follower->following()->where('followed_id', $userToUnfollow->id)->exists()) {
            return false;
        }

        $follower->following()->detach($userToUnfollow->id);

        return true;
    }
}
