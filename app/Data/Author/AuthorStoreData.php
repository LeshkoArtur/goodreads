<?php

namespace App\Data\Author;

use App\Enums\TypeOfWork;
use Illuminate\Http\Request;

readonly class AuthorStoreData
{
    public function __construct(
        public string $name,
        public ?string $bio = null,
        public ?string $birth_date = null,
        public ?string $birth_place = null,
        public ?string $nationality = null,
        public ?string $website = null,
        public ?string $profile_picture = null,
        public ?string $death_date = null,
        /** @var array<string, string>|null Example: ['twitter' => 'url', 'facebook' => 'url'] */
        public ?array $social_media_links = null,
        /** @var array<int, string>|null Array of image URLs */
        public ?array $media_images = null,
        /** @var array<int, string>|null Array of video URLs */
        public ?array $media_videos = null,
        /** @var array<int, string>|null Array of fun facts */
        public ?array $fun_facts = null,
        public ?TypeOfWork $type_of_work = null,
        /** @var array<int, string>|null Array of user IDs */
        public ?array $user_ids = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            bio: $data['bio'] ?? null,
            birth_date: $data['birth_date'] ?? null,
            birth_place: $data['birth_place'] ?? null,
            nationality: $data['nationality'] ?? null,
            website: $data['website'] ?? null,
            profile_picture: $data['profile_picture'] ?? null,
            death_date: $data['death_date'] ?? null,
            social_media_links: $data['social_media_links'] ?? null,
            media_images: $data['media_images'] ?? null,
            media_videos: $data['media_videos'] ?? null,
            fun_facts: $data['fun_facts'] ?? null,
            type_of_work: isset($data['type_of_work']) ? TypeOfWork::from($data['type_of_work']) : null,
            user_ids: $data['user_ids'] ?? null,
        );
    }
}
