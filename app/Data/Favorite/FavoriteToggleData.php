<?php

namespace App\Data\Favorite;

use Illuminate\Http\Request;

readonly class FavoriteToggleData
{
    public function __construct(
        public string $favoriteable_type,
        public string $favoriteable_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            favoriteable_type: $data['favoriteable_type'],
            favoriteable_id: $data['favoriteable_id'],
        );
    }
}
