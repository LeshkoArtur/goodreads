<?php

namespace App\Actions\Users;

use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class FollowUser
{
    use AsAction;

    public function handle(User $userToFollow, User $follower): bool
    {
        if ($follower->following()->where('followed_id', $userToFollow->id)->exists()) {
            return false;
        }

        $follower->following()->attach($userToFollow->id, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return true;
    }
}
