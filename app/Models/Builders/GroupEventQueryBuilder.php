<?php

namespace App\Models\Builders;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class GroupEventQueryBuilder extends Builder
{
    /**
     * Події для певної групи.
     */
    public function forGroup(string $groupId): static
    {
        return $this->where('group_id', $groupId);
    }

    /**
     * Події, створені певним користувачем.
     */
    public function byCreator(string $creatorId): static
    {
        return $this->where('creator_id', $creatorId);
    }

    /**
     * Події з певним статусом.
     */
    public function withStatus(EventStatus $status): static
    {
        return $this->where('status', $status);
    }

    /**
     * Події, що відбудуться після певної дати.
     */
    public function afterDate(Carbon $date): static
    {
        return $this->where('event_date', '>', $date->toDateTimeString());
    }

    /**
     * Події в певному місці.
     */
    public function atLocation(string $location): static
    {
        return $this->where('location', 'like', '%'.$location.'%');
    }

    /**
     * Події з RSVP.
     */
    public function withRsvps(): static
    {
        return $this->has('rsvps');
    }
}
