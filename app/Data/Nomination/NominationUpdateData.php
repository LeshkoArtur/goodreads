<?php

namespace App\Data\Nomination;

use Illuminate\Http\Request;

readonly class NominationUpdateData
{
    public function __construct(
        public string $name,
        public ?string $description = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
        );
    }
}
