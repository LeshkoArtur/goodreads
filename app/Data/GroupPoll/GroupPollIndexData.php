<?php

namespace App\Data\GroupPoll;

use Illuminate\Http\Request;

readonly class GroupPollIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $group_id = null,
        public ?string $creator_id = null,
        public ?bool $is_active = null,
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
            group_id: $data['group_id'] ?? null,
            creator_id: $data['creator_id'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
        );
    }
}
