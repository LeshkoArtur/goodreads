<?php

namespace App\Actions\PollVotes;

use App\Models\PollOption;
use App\Models\PollVote;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPollVoteOption
{
    use AsAction;

    public function handle(PollVote $pollVote): PollOption
    {
        return $pollVote->option;
    }
}
