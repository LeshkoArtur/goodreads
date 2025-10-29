<?php

namespace App\Actions\Collections;

use App\Models\Collection;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnfollowCollection
{
    use AsAction;

    public function handle(Collection $collection, User $user): bool
    {
        $follow = $user->follows()
            ->where('followable_type', Collection::class)
            ->where('followable_id', $collection->id)
            ->first();

        if (! $follow) {
            return false;
        }

        $follow->delete();

        return true;
    }
}
