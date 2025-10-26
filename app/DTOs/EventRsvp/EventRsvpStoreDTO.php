<?php

namespace App\DTOs\EventRsvp;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\EventResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EventRsvpStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $groupEventId,
        public readonly string $userId,
        public readonly EventResponse $response,
        public readonly array|Collection|null $mediaImages = null,
        public readonly array|Collection|null $socialMediaLinks = null
    ) {}

    public static function fromRequest(Request $request): static
    {
        return self::makeDTO($request->all());
    }

    public static function fromArray(array $data): static
    {
        return self::makeDTO($data);
    }

    private static function makeDTO(array $data): static
    {
        return new static(
            groupEventId: $data['group_event_id'],
            userId: $data['user_id'],
            response: EventResponse::from($data['response']),
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
