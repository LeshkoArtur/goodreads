<?php

namespace App\Actions\PollOptions;

use App\Data\PollOption\PollOptionRelationIndexData;
use App\Models\PollOption;
use Illuminate\Pagination\LengthAwarePaginator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPollOptionVotes
{
    use AsAction;

    public function handle(PollOption $pollOption, PollOptionRelationIndexData $data): LengthAwarePaginator
    {
        return $pollOption->votes()
            ->with(['user', 'poll'])
            ->paginate(
                perPage: $data->per_page ?? 15,
                page: $data->page ?? 1
            );
    }
}
