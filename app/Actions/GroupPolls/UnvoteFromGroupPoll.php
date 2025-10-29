<?php

namespace App\Actions\GroupPolls;

use App\Models\GroupPoll;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class UnvoteFromGroupPoll
{
    use AsAction;

    public function handle(GroupPoll $groupPoll, User $user): bool
    {
        $deleted = $groupPoll->votes()
            ->where('user_id', $user->id)
            ->delete();

        return $deleted > 0;
    }
}
