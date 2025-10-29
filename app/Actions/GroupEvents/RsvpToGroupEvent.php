<?php

namespace App\Actions\GroupEvents;

use App\Data\GroupEvent\GroupEventRsvpData;
use App\Models\EventRsvp;
use App\Models\GroupEvent;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class RsvpToGroupEvent
{
    use AsAction;

    public function handle(GroupEvent $groupEvent, GroupEventRsvpData $data, User $user): EventRsvp
    {
        $rsvp = EventRsvp::updateOrCreate(
            [
                'group_event_id' => $groupEvent->id,
                'user_id' => $user->id,
            ],
            [
                'response' => $data->response,
            ]
        );

        return $rsvp->fresh(['user', 'event']);
    }
}
