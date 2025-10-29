<?php

namespace App\Actions\PollVotes;

use App\Data\PollVote\PollVoteChangeOptionData;
use App\Models\PollVote;
use Lorisleiva\Actions\Concerns\AsAction;

class ChangePollVoteOption
{
    use AsAction;

    public function handle(PollVote $pollVote, PollVoteChangeOptionData $data): PollVote
    {
        $pollVote->poll_option_id = $data->poll_option_id;
        $pollVote->save();

        return $pollVote->fresh(['poll', 'option', 'user']);
    }
}
