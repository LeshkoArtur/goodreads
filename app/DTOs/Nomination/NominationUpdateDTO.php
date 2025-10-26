<?php

namespace App\DTOs\Nomination;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class NominationUpdateDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly ?string $awardId = null,
        public readonly ?string $name = null,
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
            awardId: $data['award_id'] ?? null,
            name: $data['name'] ?? null,
            description: $data['description'] ?? null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
