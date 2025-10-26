<?php

namespace App\DTOs\GroupModerationLog;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupModerationLogStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $groupId,
        public readonly string $moderatorId,
        public readonly string $action,
        public readonly string $targetableId,
        public readonly string $targetableType,
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
            groupId: $data['group_id'],
            moderatorId: $data['moderator_id'],
            action: $data['action'],
            targetableId: $data['targetable_id'],
            targetableType: $data['targetable_type'],
            description: $data['description'] ?? null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
