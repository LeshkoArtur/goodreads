<?php

namespace App\Actions\GroupPolls;

use App\Data\GroupPoll\GroupPollRelationIndexData;
use App\Models\GroupPoll;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPollOptions
{
    use AsAction;

    public function handle(GroupPoll $groupPoll, GroupPollRelationIndexData $data): LengthAwarePaginator
    {
        return $groupPoll->options()
            ->withCount(['votes'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
