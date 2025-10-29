<?php

namespace App\Data\PollVote;

use Illuminate\Http\Request;

readonly class PollVoteIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
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
            q: $data['q'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
            group_poll_id: $data['group_poll_id'] ?? null,
            poll_option_id: $data['poll_option_id'] ?? null,
            user_id: $data['user_id'] ?? null,
        );
    }
}
