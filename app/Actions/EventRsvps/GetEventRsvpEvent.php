<?php

namespace App\Actions\EventRsvps;

use App\Models\EventRsvp;
use App\Models\GroupEvent;
use Lorisleiva\Actions\Concerns\AsAction;

class GetEventRsvpEvent
{
    use AsAction;

    public function handle(EventRsvp $eventRsvp): GroupEvent
    {
        return $eventRsvp->event;
    }
}
