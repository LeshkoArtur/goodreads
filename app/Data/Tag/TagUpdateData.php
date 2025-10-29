<?php

namespace App\Data\Tag;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

readonly class TagUpdateData
{
    public function __construct(
        public ?string $name = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: isset($data['name']) ? Str::lower($data['name']) : null,
        );
    }
}
