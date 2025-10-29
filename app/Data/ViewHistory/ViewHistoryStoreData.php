<?php

namespace App\Data\ViewHistory;

use Illuminate\Http\Request;

readonly class ViewHistoryStoreData
{
    public function __construct(
        public string $user_id,
        public string $viewable_id,
        public string $viewable_type,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            viewable_id: $data['viewable_id'],
            viewable_type: $data['viewable_type'],
        );
    }
}
