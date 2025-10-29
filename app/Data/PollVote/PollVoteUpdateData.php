<?php

namespace App\Data\PollVote;

use Illuminate\Http\Request;

readonly class PollVoteUpdateData
{
    public function __construct(
        public ?string $group_poll_id = null,
        public ?string $poll_option_id = null,
        public ?string $user_id = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            group_poll_id: $data['group_poll_id'] ?? null,
            poll_option_id: $data['poll_option_id'] ?? null,
            user_id: $data['user_id'] ?? null,
        );
    }
}
