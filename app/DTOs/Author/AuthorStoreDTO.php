<?php

namespace App\DTOs\Author;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\TypeOfWork;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AuthorStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $name,
        public readonly ?string $bio = null,
        public readonly ?string $birthDate = null,
        public readonly ?string $birthPlace = null,
        public readonly ?string $nationality = null,
        public readonly ?string $website = null,
        public readonly ?string $profilePicture = null,
        public readonly ?string $deathDate = null,
        public readonly ?array $userIds = null,
        public readonly array|Collection|null $socialMediaLinks = null,
        public readonly array|Collection|null $mediaImages = null,
        public readonly array|Collection|null $mediaVideos = null,
        public readonly array|Collection|null $funFacts = null,
        public readonly ?TypeOfWork $typeOfWork = null
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
            name: $data['name'],
            bio: $data['bio'] ?? null,
            birthDate: $data['birth_date'] ?? null,
            birthPlace: $data['birth_place'] ?? null,
            nationality: $data['nationality'] ?? null,
            website: $data['website'] ?? null,
            profilePicture: $data['profile_picture'] ?? null,
            deathDate: $data['death_date'] ?? null,
            userIds: self::processJsonArray($data['user_ids'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null),
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            mediaVideos: self::processJsonArray($data['media_videos'] ?? null),
            funFacts: self::processJsonArray($data['fun_facts'] ?? null),
            typeOfWork: !empty($data['type_of_work'])
                ? TypeOfWork::from($data['type_of_work'])
                : null,
        );
    }
}
