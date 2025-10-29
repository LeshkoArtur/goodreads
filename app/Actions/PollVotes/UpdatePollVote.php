<?php

namespace App\Actions\PollVotes;

use App\Data\PollVote\PollVoteUpdateData;
use App\Models\PollVote;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePollVote
{
    use AsAction;

    public function handle(PollVote $pollVote, PollVoteUpdateData $data): PollVote
    {
        $pollVote->update(array_filter([
            'group_poll_id' => $data->group_poll_id,
            'poll_option_id' => $data->poll_option_id,
            'user_id' => $data->user_id,
        ], fn ($value) => $value !== null));

        return $pollVote->fresh(['poll', 'option', 'user']);
    }
}
