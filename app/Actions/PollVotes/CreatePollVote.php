<?php

namespace App\Actions\PollVotes;

use App\Data\PollVote\PollVoteStoreData;
use App\Models\PollVote;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePollVote
{
    use AsAction;

    public function handle(PollVoteStoreData $data, User $user): PollVote
    {
        $pollVote = new PollVote;
        $pollVote->group_poll_id = $data->group_poll_id;
        $pollVote->poll_option_id = $data->poll_option_id;
        $pollVote->user_id = $user->id;
        $pollVote->save();

        return $pollVote->fresh(['poll', 'option', 'user']);
    }
}
