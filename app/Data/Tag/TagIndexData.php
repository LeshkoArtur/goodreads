<?php

namespace App\Data\Tag;

use Illuminate\Http\Request;

readonly class TagIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?int $min_taggable_count = null,
        public ?int $max_taggable_count = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            min_taggable_count: $data['min_taggable_count'] ?? null,
            max_taggable_count: $data['max_taggable_count'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
