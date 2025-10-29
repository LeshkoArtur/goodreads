<?php

namespace App\Data\Tag;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

readonly class TagStoreData
{
    public function __construct(
        public string $name,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: Str::lower($data['name']),
        );
    }
}
