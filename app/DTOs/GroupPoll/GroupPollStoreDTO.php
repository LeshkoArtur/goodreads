<?php

namespace App\DTOs\GroupPoll;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupPollStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $groupId,
        public readonly string $creatorId,
        public readonly string $question,
        public readonly bool $isActive = true,
        public readonly ?string $description = null,
        public readonly array|Collection|null $options = null,
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
            question: $data['question'],
            isActive: $data['is_active'] ?? true,
            description: $data['description'] ?? null,
            options: self::processJsonArray($data['options'] ?? null),
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
