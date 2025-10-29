<?php

namespace App\Data\EventRsvp;

use App\Enums\EventResponse;
use Illuminate\Http\Request;

readonly class EventRsvpIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $group_event_id = null,
        public ?string $user_id = null,
        public ?EventResponse $response = null,
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
            group_event_id: $data['group_event_id'] ?? null,
            user_id: $data['user_id'] ?? null,
            response: isset($data['response']) ? EventResponse::from($data['response']) : null,
        );
    }
}
