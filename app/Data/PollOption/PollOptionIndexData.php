<?php

namespace App\Data\PollOption;

use Illuminate\Http\Request;

readonly class PollOptionIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $group_poll_id = null,
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
        );
    }
}
