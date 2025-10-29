<?php

namespace App\Actions\EventRsvps;

use App\Data\EventRsvp\EventRsvpStoreData;
use App\Models\EventRsvp;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateEventRsvp
{
    use AsAction;

    public function handle(EventRsvpStoreData $data, User $user): EventRsvp
    {
        $eventRsvp = new EventRsvp;
        $eventRsvp->group_event_id = $data->group_event_id;
        $eventRsvp->user_id = $user->id;
        $eventRsvp->response = $data->response;
        $eventRsvp->save();

        return $eventRsvp->fresh(['event', 'user']);
    }
}
