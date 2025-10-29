<?php

namespace App\Data\GroupPost;

use Illuminate\Http\Request;

readonly class GroupPostRelationIndexData
{
    public function __construct(
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
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
