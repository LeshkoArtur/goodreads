<?php

namespace App\Data\User;

use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Http\Request;

readonly class UserIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $location = null,
        public ?string $min_birthday = null,
        public ?string $max_birthday = null,
        public ?Role $role = null,
        public ?Gender $gender = null,
        public ?bool $is_public = null,
        /** @var array<string, string>|null */
        public ?array $social_media_links = null,
        /** @var array<int, string>|null */
        public ?array $author_ids = null,
        /** @var array<int, string>|null */
        public ?array $group_ids = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
            location: $data['location'] ?? null,
            min_birthday: $data['min_birthday'] ?? null,
            max_birthday: $data['max_birthday'] ?? null,
            role: isset($data['role']) ? Role::from($data['role']) : null,
            gender: isset($data['gender']) ? Gender::from($data['gender']) : null,
            is_public: $data['is_public'] ?? null,
            social_media_links: $data['social_media_links'] ?? null,
            author_ids: $data['author_ids'] ?? null,
            group_ids: $data['group_ids'] ?? null,
        );
    }
}
