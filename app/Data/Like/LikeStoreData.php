<?php

namespace App\Data\Like;

use Illuminate\Http\Request;

readonly class LikeStoreData
{
    public function __construct(
        public string $likeable_type,
        public string $likeable_id,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            likeable_type: $data['likeable_type'],
            likeable_id: $data['likeable_id'],
        );
    }
}
