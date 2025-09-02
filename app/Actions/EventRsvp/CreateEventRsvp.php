<?php

namespace App\Actions\EventRsvps;

use App\DTOs\EventRsvp\EventRsvpStoreDTO;
use App\Models\EventRsvp;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateEventRsvp
{
    use AsAction;

    /**
     * Створити нову RSVP на подію.
     *
     * @param EventRsvpStoreDTO $dto
     * @return EventRsvp
     */
    public function handle(EventRsvpStoreDTO $dto): EventRsvp
    {
        $eventRsvp = new EventRsvp();
        $eventRsvp->group_event_id = $dto->groupEventId;
        $eventRsvp->user_id = $dto->userId;
        $eventRsvp->response = $dto->response;

        $eventRsvp->save();

        return $eventRsvp->load(['event', 'user']);
    }
}
