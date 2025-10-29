<?php

namespace App\Actions\Collections;

use App\Models\Collection;
use App\Models\Follow;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class FollowCollection
{
    use AsAction;

    public function handle(Collection $collection, User $user): bool
    {
        if (Follow::where('user_id', $user->id)
            ->where('followable_type', Collection::class)
            ->where('followable_id', $collection->id)
            ->exists()) {
            return false;
        }

        Follow::create([
            'user_id' => $user->id,
            'followable_type' => Collection::class,
            'followable_id' => $collection->id,
        ]);

        return true;
    }
}
