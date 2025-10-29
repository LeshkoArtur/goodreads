<?php

namespace App\Data\Favorite;

use Illuminate\Http\Request;

readonly class FavoriteIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $user_id = null,
        public ?string $favoriteable_type = null,
        public ?string $favoriteable_id = null,
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
            user_id: $data['user_id'] ?? null,
            favoriteable_type: $data['favoriteable_type'] ?? null,
            favoriteable_id: $data['favoriteable_id'] ?? null,
        );
    }
}
