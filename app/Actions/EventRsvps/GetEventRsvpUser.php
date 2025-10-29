<?php

namespace App\Actions\EventRsvps;

use App\Models\EventRsvp;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetEventRsvpUser
{
    use AsAction;

    public function handle(EventRsvp $eventRsvp): User
    {
        return $eventRsvp->user;
    }
}
