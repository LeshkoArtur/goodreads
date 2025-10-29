<?php

namespace App\Actions\GroupEvents;

use App\Data\GroupEvent\GroupEventStoreData;
use App\Models\GroupEvent;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGroupEvent
{
    use AsAction;

    public function handle(GroupEventStoreData $data, User $user): GroupEvent
    {
        $groupEvent = new GroupEvent;
        $groupEvent->group_id = $data->group_id;
        $groupEvent->creator_id = $user->id;
        $groupEvent->title = $data->title;
        $groupEvent->description = $data->description;
        $groupEvent->event_date = $data->event_date;
        $groupEvent->location = $data->location;
        $groupEvent->status = $data->status;
        $groupEvent->save();

        return $groupEvent->fresh(['group', 'creator']);
    }
}
