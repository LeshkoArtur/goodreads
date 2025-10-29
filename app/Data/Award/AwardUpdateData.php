<?php

namespace App\Data\Award;

use Illuminate\Http\Request;

readonly class AwardUpdateData
{
    public function __construct(
        public string $name,
        public int $year,
        public ?string $description = null,
        public ?string $organizer = null,
        public ?string $country = null,
        public ?string $ceremony_date = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            year: $data['year'],
            description: $data['description'] ?? null,
            organizer: $data['organizer'] ?? null,
            country: $data['country'] ?? null,
            ceremony_date: $data['ceremony_date'] ?? null,
        );
    }
}
