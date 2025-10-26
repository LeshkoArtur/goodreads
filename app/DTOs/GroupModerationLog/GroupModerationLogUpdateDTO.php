<?php

namespace App\DTOs\GroupModerationLog;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupModerationLogUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $groupId = null,
        public readonly ?string $moderatorId = null,
        public readonly ?string $action = null,
        public readonly ?string $targetableId = null,
        public readonly ?string $targetableType = null,
        public readonly ?string $description = null,
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
            groupId: $data['group_id'] ?? null,
            moderatorId: $data['moderator_id'] ?? null,
            action: $data['action'] ?? null,
            targetableId: $data['targetable_id'] ?? null,
            targetableType: $data['targetable_type'] ?? null,
            description: $data['description'] ?? null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
