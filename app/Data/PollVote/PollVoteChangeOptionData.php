<?php

namespace App\Data\PollVote;

use Illuminate\Http\Request;

readonly class PollVoteChangeOptionData
{
    public function __construct(
        public string $poll_option_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            poll_option_id: $data['poll_option_id'],
        );
    }
}
