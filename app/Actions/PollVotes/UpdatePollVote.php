<?php

namespace App\Actions\PollVotes;

use App\DTOs\PollVote\PollVoteUpdateDTO;
use App\Models\PollVote;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePollVote
{
    use AsAction;

    /**
     * Оновити існуючий голос в опитуванні.
     *
     * @param PollVote $pollVote
     * @param PollVoteUpdateDTO $dto
     * @return PollVote
     */
    public function handle(PollVote $pollVote, PollVoteUpdateDTO $dto): PollVote
    {
        $attributes = [
            'poll_option_id' => $dto->pollOptionId,
        ];

        $pollVote->fill(array_filter($attributes, fn($value) => $value !== null));

        $pollVote->save();

        return $pollVote->load(['poll', 'option', 'user']);
    }
}
