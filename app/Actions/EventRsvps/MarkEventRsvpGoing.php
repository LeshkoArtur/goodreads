<?php

namespace App\Actions\EventRsvps;

use App\Enums\EventResponse;
use App\Models\EventRsvp;
use Lorisleiva\Actions\Concerns\AsAction;

class MarkEventRsvpGoing
{
    use AsAction;

    public function handle(EventRsvp $eventRsvp): EventRsvp
    {
        $eventRsvp->response = EventResponse::GOING;
        $eventRsvp->save();

        return $eventRsvp->fresh(['event', 'user']);
    }
}
