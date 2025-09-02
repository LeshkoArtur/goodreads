<?php

namespace App\DTOs\PollOption;

use Illuminate\Http\Request;

class PollOptionStoreDTO
{
    /**
     * @param string $groupPollId ID опитування
     * @param string $text Текст варіанту
     * @param int $voteCount Кількість голосів
     */
    public function __construct(
        public readonly string $groupPollId,
        public readonly string $text,
        public readonly int $voteCount = 0
    ) {}

    /**
     * Створити PollOptionStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            groupPollId: $request->input('group_poll_id'),
            text: $request->input('text'),
            voteCount: $request->input('vote_count', 0)
        );
    }
}
