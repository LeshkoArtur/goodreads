<?php

namespace App\Data\Like;

use Illuminate\Http\Request;

readonly class LikeUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $likeable_id = null,
        public ?string $likeable_type = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            likeable_id: $data['likeable_id'] ?? null,
            likeable_type: $data['likeable_type'] ?? null,
        );
    }
}
