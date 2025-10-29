<?php

namespace App\Actions\GroupEvents;

use App\Data\GroupEvent\GroupEventRelationIndexData;
use App\Models\GroupEvent;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupEventAttendees
{
    use AsAction;

    public function handle(GroupEvent $groupEvent, GroupEventRelationIndexData $data): LengthAwarePaginator
    {
        return $groupEvent->rsvps()
            ->where('response', \App\Enums\EventResponse::GOING)
            ->with(['user'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
