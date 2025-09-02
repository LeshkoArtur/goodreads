<?php

namespace App\Actions\EventRsvps;

use App\DTOs\EventRsvp\EventRsvpUpdateDTO;
use App\Models\EventRsvp;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateEventRsvp
{
    use AsAction;

    /**
     * Оновити існуючу RSVP на подію.
     *
     * @param EventRsvp $eventRsvp
     * @param EventRsvpUpdateDTO $dto
     * @return EventRsvp
     */
    public function handle(EventRsvp $eventRsvp, EventRsvpUpdateDTO $dto): EventRsvp
    {
        $attributes = [
            'response' => $dto->response,
        ];

        $eventRsvp->fill(array_filter($attributes, fn($value) => $value !== null));

        $eventRsvp->save();

        return $eventRsvp->load(['event', 'user']);
    }
}
