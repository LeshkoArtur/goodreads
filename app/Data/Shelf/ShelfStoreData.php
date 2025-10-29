<?php

namespace App\Data\Shelf;

use Illuminate\Http\Request;

readonly class ShelfStoreData
{
    public function __construct(
        public string $user_id,
        public string $name,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            name: $data['name'],
        );
    }
}
