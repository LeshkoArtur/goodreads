<?php

namespace App\Actions\GroupEvents;

use App\DTOs\GroupEvent\GroupEventStoreDTO;
use App\Models\GroupEvent;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupEvent
{
    use AsAction;

    /**
     * Створити нову подію групи.
     *
     * @param GroupEventStoreDTO $dto
     * @return GroupEvent
     */
    public function handle(GroupEventStoreDTO $dto): GroupEvent
    {
        $groupEvent = new GroupEvent();
        $groupEvent->group_id = $dto->groupId;
        $groupEvent->creator_id = $dto->creatorId;
        $groupEvent->title = $dto->title;
        $groupEvent->description = $dto->description;
        $groupEvent->event_date = $dto->eventDate;
        $groupEvent->location = $dto->location;
        $groupEvent->status = $dto->status;

        $groupEvent->save();

        return $groupEvent->load(['group', 'creator', 'rsvps']);
    }
}
