<?php

namespace App\Data\Award;

use Illuminate\Http\Request;

readonly class AwardIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?int $year = null,
        public ?string $organizer = null,
        public ?string $country = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
            year: $data['year'] ?? null,
            organizer: $data['organizer'] ?? null,
            country: $data['country'] ?? null,
        );
    }
}
