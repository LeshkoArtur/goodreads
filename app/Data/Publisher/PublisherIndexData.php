<?php

namespace App\Data\Publisher;

use Illuminate\Http\Request;

readonly class PublisherIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
        public ?string $country = null,
        public ?int $min_founded_year = null,
        public ?int $max_founded_year = null,
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
            country: $data['country'] ?? null,
            min_founded_year: $data['min_founded_year'] ?? null,
            max_founded_year: $data['max_founded_year'] ?? null,
        );
    }
}
