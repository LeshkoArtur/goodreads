<?php

namespace App\Data\Like;

use Illuminate\Http\Request;

readonly class LikeIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $user_id = null,
        public ?string $likeable_type = null,
        public ?string $likeable_id = null,
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
            likeable_type: $data['likeable_type'] ?? null,
            likeable_id: $data['likeable_id'] ?? null,
        );
    }
}
