<?php

namespace App\Actions\PollVotes;

use App\Models\GroupPoll;
use App\Models\PollVote;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPollVotePoll
{
    use AsAction;

    public function handle(PollVote $pollVote): GroupPoll
    {
        return $pollVote->poll;
    }
}
