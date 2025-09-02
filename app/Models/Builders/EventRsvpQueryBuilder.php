<?php

namespace App\Models\Builders;

use App\Enums\EventResponse;
use Illuminate\Database\Eloquent\Builder;

class EventRsvpQueryBuilder extends Builder
{
    /**
     * Відповіді RSVP для певної події.
     */
    public function forEvent(string $eventId): static
    {
        return $this->where('group_event_id', $eventId);
    }

    /**
     * Відповіді RSVP від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Відповіді RSVP з певною реакцією.
     */
    public function withResponse(EventResponse $response): static
    {
        return $this->where('response', $response);
    }
}
