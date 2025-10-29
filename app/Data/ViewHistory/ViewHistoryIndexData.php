<?php

namespace App\Data\ViewHistory;

use Illuminate\Http\Request;

readonly class ViewHistoryIndexData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $viewable_type = null,
        public ?string $viewable_id = null,
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
            user_id: $data['user_id'] ?? null,
            viewable_type: $data['viewable_type'] ?? null,
            viewable_id: $data['viewable_id'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
