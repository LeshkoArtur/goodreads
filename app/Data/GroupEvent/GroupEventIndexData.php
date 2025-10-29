<?php

namespace App\Data\GroupEvent;

use App\Enums\EventStatus;
use Illuminate\Http\Request;

readonly class GroupEventIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $group_id = null,
        public ?string $creator_id = null,
        public ?EventStatus $status = null,
        public ?string $location = null,
        public ?string $min_event_date = null,
        public ?string $max_event_date = null,
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
            status: isset($data['status']) ? EventStatus::from($data['status']) : null,
            location: $data['location'] ?? null,
            min_event_date: $data['min_event_date'] ?? null,
            max_event_date: $data['max_event_date'] ?? null,
        );
    }
}
