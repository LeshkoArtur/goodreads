<?php

namespace App\Data\PollVote;

use Illuminate\Http\Request;

readonly class PollVoteStoreData
{
    public function __construct(
        public string $group_poll_id,
        public string $poll_option_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            group_poll_id: $data['group_poll_id'],
            poll_option_id: $data['poll_option_id'],
        );
    }
}
