<?php

namespace App\Data\Publisher;

use Illuminate\Http\Request;

readonly class PublisherStoreData
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?string $website = null,
        public ?string $country = null,
        public ?int $founded_year = null,
        public ?string $logo = null,
        public ?string $contact_email = null,
        public ?string $phone = null,
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
            website: $data['website'] ?? null,
            country: $data['country'] ?? null,
            founded_year: $data['founded_year'] ?? null,
            logo: $data['logo'] ?? null,
            contact_email: $data['contact_email'] ?? null,
            phone: $data['phone'] ?? null,
        );
    }
}
