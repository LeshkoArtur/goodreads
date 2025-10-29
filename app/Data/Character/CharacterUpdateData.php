<?php

namespace App\Data\Character;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

readonly class CharacterUpdateData
{
    public function __construct(
        public string $name,
        public ?Collection $other_names = null,
        public ?string $race = null,
        public ?string $nationality = null,
        public ?string $residence = null,
        public ?string $biography = null,
        public ?Collection $fun_facts = null,
        public ?Collection $links = null,
        public ?Collection $media_images = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            other_names: isset($data['other_names']) ? collect($data['other_names']) : null,
            race: $data['race'] ?? null,
            nationality: $data['nationality'] ?? null,
            residence: $data['residence'] ?? null,
            biography: $data['biography'] ?? null,
            fun_facts: isset($data['fun_facts']) ? collect($data['fun_facts']) : null,
            links: isset($data['links']) ? collect($data['links']) : null,
            media_images: isset($data['media_images']) ? collect($data['media_images']) : null,
        );
    }
}
