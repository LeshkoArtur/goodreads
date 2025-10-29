<?php

namespace App\Actions\GroupPolls;

use App\Data\GroupPoll\GroupPollVoteData;
use App\Models\GroupPoll;
use App\Models\PollVote;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class VoteOnGroupPoll
{
    use AsAction;

    public function handle(GroupPoll $groupPoll, GroupPollVoteData $data, User $user): PollVote
    {
        $vote = PollVote::updateOrCreate(
            [
                'group_poll_id' => $groupPoll->id,
                'user_id' => $user->id,
            ],
            [
                'poll_option_id' => $data->poll_option_id,
            ]
        );

        return $vote->fresh(['user', 'option', 'poll']);
    }
}
