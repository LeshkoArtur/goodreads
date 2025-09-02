<?php

namespace App\Actions\PollVotes;

use App\DTOs\PollVote\PollVoteStoreDTO;
use App\Models\PollVote;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePollVote
{
    use AsAction;

    /**
     * Створити новий голос в опитуванні.
     *
     * @param PollVoteStoreDTO $dto
     * @return PollVote
     */
    public function handle(PollVoteStoreDTO $dto): PollVote
    {
        $pollVote = new PollVote();
        $pollVote->group_poll_id = $dto->groupPollId;
        $pollVote->poll_option_id = $dto->pollOptionId;
        $pollVote->user_id = $dto->userId;

        $pollVote->save();

        return $pollVote->load(['poll', 'option', 'user']);
    }
}
