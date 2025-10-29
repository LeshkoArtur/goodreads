<?php

namespace App\Data\ViewHistory;

use Illuminate\Http\Request;

readonly class ViewHistoryUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $viewable_id = null,
        public ?string $viewable_type = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            viewable_id: $data['viewable_id'] ?? null,
            viewable_type: $data['viewable_type'] ?? null,
        );
    }
}
