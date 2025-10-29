<?php

namespace App\Actions\EventRsvps;

use App\Enums\EventResponse;
use App\Models\EventRsvp;
use Lorisleiva\Actions\Concerns\AsAction;

class MarkEventRsvpMaybe
{
    use AsAction;

    public function handle(EventRsvp $eventRsvp): EventRsvp
    {
        $eventRsvp->response = EventResponse::MAYBE;
        $eventRsvp->save();

        return $eventRsvp->fresh(['event', 'user']);
    }
}
