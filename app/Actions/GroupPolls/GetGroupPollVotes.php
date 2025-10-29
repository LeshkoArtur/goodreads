<?php

namespace App\Actions\GroupPolls;

use App\Data\GroupPoll\GroupPollRelationIndexData;
use App\Models\GroupPoll;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetGroupPollVotes
{
    use AsAction;

    public function handle(GroupPoll $groupPoll, GroupPollRelationIndexData $data): LengthAwarePaginator
    {
        return $groupPoll->votes()
            ->with(['user', 'pollOption'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
