<?php

namespace App\Data\EventRsvp;

use App\Enums\EventResponse;
use Illuminate\Http\Request;

readonly class EventRsvpStoreData
{
    public function __construct(
        public string $group_event_id,
        public EventResponse $response,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            group_event_id: $data['group_event_id'],
            response: EventResponse::from($data['response']),
        );
    }
}
