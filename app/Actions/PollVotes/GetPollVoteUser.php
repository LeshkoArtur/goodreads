<?php

namespace App\Actions\PollVotes;

use App\Models\PollVote;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPollVoteUser
{
    use AsAction;

    public function handle(PollVote $pollVote): User
    {
        return $pollVote->user;
    }
}
