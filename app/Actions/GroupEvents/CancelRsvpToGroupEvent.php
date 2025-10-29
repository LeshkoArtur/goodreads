<?php

namespace App\Actions\GroupEvents;

use App\Models\GroupEvent;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CancelRsvpToGroupEvent
{
    use AsAction;

    public function handle(GroupEvent $groupEvent, User $user): bool
    {
        $deleted = $groupEvent->rsvps()
            ->where('user_id', $user->id)
            ->delete();

        return $deleted > 0;
    }
}
