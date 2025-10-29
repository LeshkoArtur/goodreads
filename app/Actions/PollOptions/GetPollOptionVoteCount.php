<?php

namespace App\Actions\PollOptions;

use App\Models\PollOption;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPollOptionVoteCount
{
    use AsAction;

    public function handle(PollOption $pollOption): int
    {
        return $pollOption->vote_count;
    }
}
