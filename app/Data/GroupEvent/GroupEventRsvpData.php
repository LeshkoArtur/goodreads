<?php

namespace App\Data\GroupEvent;

use App\Enums\EventResponse;
use Illuminate\Http\Request;

readonly class GroupEventRsvpData
{
    public function __construct(
        public EventResponse $response,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            response: EventResponse::from($data['response']),
        );
    }
}
