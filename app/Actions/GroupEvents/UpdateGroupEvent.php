<?php

namespace App\Actions\GroupEvents;

use App\Data\GroupEvent\GroupEventUpdateData;
use App\Models\GroupEvent;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGroupEvent
{
    use AsAction;

    public function handle(GroupEvent $groupEvent, GroupEventUpdateData $data): GroupEvent
    {
        $groupEvent->title = $data->title;
        $groupEvent->description = $data->description;
        $groupEvent->event_date = $data->event_date;
        $groupEvent->location = $data->location;

        if ($data->status !== null) {
            $groupEvent->status = $data->status;
        }

        $groupEvent->save();

        return $groupEvent->fresh(['group', 'creator']);
    }
}
