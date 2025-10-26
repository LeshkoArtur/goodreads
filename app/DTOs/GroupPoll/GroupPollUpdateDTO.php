<?php

namespace App\DTOs\GroupPoll;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GroupPollUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $groupId = null,
        public readonly ?string $creatorId = null,
        public readonly ?string $question = null,
        public readonly ?bool $isActive = null,
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
            groupId: $data['group_id'] ?? null,
            creatorId: $data['creator_id'] ?? null,
            question: $data['question'] ?? null,
            isActive: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            description: $data['description'] ?? null,
            options: self::processJsonArray($data['options'] ?? null),
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
