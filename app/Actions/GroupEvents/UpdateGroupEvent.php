<?php

namespace App\Actions\GroupEvents;

use App\DTOs\GroupEvent\GroupEventUpdateDTO;
use App\Models\GroupEvent;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupEvent
{
    use AsAction;

    /**
     * Оновити існуючу подію групи.
     *
     * @param GroupEvent $groupEvent
     * @param GroupEventUpdateDTO $dto
     * @return GroupEvent
     */
    public function handle(GroupEvent $groupEvent, GroupEventUpdateDTO $dto): GroupEvent
    {
        $attributes = [
            'title' => $dto->title,
            'description' => $dto->description,
            'event_date' => $dto->eventDate,
            'location' => $dto->location,
            'status' => $dto->status,
        ];

        $groupEvent->fill(array_filter($attributes, fn($value) => $value !== null));

        $groupEvent->save();

        return $groupEvent->load(['group', 'creator', 'rsvps']);
    }
}
