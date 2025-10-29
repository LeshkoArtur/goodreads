<?php

namespace App\Actions\EventRsvps;

use App\Enums\EventResponse;
use App\Models\EventRsvp;
use Lorisleiva\Actions\Concerns\AsAction;

class MarkEventRsvpNotGoing
{
    use AsAction;

    public function handle(EventRsvp $eventRsvp): EventRsvp
    {
        $eventRsvp->response = EventResponse::NOT_GOING;
        $eventRsvp->save();

        return $eventRsvp->fresh(['event', 'user']);
    }
}
