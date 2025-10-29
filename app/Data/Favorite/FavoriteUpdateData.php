<?php

namespace App\Data\Favorite;

use Illuminate\Http\Request;

readonly class FavoriteUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $favoriteable_id = null,
        public ?string $favoriteable_type = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            favoriteable_id: $data['favoriteable_id'] ?? null,
            favoriteable_type: $data['favoriteable_type'] ?? null,
        );
    }
}
