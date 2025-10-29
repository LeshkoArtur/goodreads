<?php

namespace App\Data\Group;

use Illuminate\Http\Request;

readonly class GroupRelationIndexData
{
    public function __construct(
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $sort = null,
        public ?string $direction = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
        );
    }
}
