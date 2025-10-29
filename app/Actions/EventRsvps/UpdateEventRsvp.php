<?php

namespace App\Actions\EventRsvps;

use App\Data\EventRsvp\EventRsvpUpdateData;
use App\Models\EventRsvp;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateEventRsvp
{
    use AsAction;

    public function handle(EventRsvp $eventRsvp, EventRsvpUpdateData $data): EventRsvp
    {
        $eventRsvp->response = $data->response;
        $eventRsvp->save();

        return $eventRsvp->fresh(['event', 'user']);
    }
}
