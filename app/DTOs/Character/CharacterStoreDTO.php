<?php

namespace App\DTOs\Character;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CharacterStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $bookId,
        public readonly string $name,
        public readonly array|Collection|null $otherNames = null,
        public readonly ?string $race = null,
        public readonly ?string $nationality = null,
        public readonly ?string $residence = null,
        public readonly ?string $biography = null,
        public readonly array|Collection|null $funFacts = null,
        public readonly array|Collection|null $links = null,
        public readonly array|Collection|null $mediaImages = null
    ) {}

    public static function fromRequest(Request $request): static
    {
        return self::makeDTO($request->all());
    }

    public static function fromArray(array $data): static
    {
        return self::makeDTO($data);
    }

    private static function makeDTO(array $data): static
    {
        return new static(
            bookId: $data['book_id'],
            name: $data['name'],
            otherNames: self::processJsonArray($data['other_names'] ?? null),
            race: $data['race'] ?? null,
            nationality: $data['nationality'] ?? null,
            residence: $data['residence'] ?? null,
            biography: $data['biography'] ?? null,
            funFacts: self::processJsonArray($data['fun_facts'] ?? null),
            links: self::processJsonArray($data['links'] ?? null),
            mediaImages: self::processJsonArray($data['media_images'] ?? null)
        );
    }
}
