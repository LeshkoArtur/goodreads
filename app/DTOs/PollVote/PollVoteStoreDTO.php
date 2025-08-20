<?php

namespace App\DTOs\PollVote;

use Illuminate\Http\Request;

class PollVoteStoreDTO
{
    /**
     * @param string $groupPollId ID опитування
     * @param string $pollOptionId ID варіанту опитування
     * @param string $userId ID користувача
     */
    public function __construct(
        public readonly string $groupPollId,
        public readonly string $pollOptionId,
        public readonly string $userId
    ) {}

    /**
     * Створити PollVoteStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            groupPollId: $request->input('group_poll_id'),
            pollOptionId: $request->input('poll_option_id'),
            userId: $request->input('user_id')
        );
    }
}
