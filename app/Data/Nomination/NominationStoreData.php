<?php

namespace App\Data\Nomination;

use Illuminate\Http\Request;

readonly class NominationStoreData
{
    public function __construct(
        public string $award_id,
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
            award_id: $data['award_id'],
            name: $data['name'],
            description: $data['description'] ?? null,
        );
    }
}
