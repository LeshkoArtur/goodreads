<?php

namespace App\DTOs\GroupEvent;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\EventStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupEventStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $groupId,
        public readonly string $creatorId,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?string $eventDate = null,
        public readonly ?string $location = null,
        public readonly ?EventStatus $status = null,
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
            groupId: $data['group_id'],
            creatorId: $data['creator_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            eventDate: $data['event_date'] ?? null,
            location: $data['location'] ?? null,
            status: !empty($data['status']) ? EventStatus::from($data['status']) : null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
