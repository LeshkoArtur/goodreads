<?php

namespace App\DTOs\Character;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CharacterStoreDTO
{
    use HandlesJsonArrays;
    /**
     * @param string $bookId ID книги
     * @param string $name Ім'я персонажа
     * @param array|Collection|null $otherNames Інші імена персонажа
     * @param string|null $race Раса персонажа
     * @param string|null $nationality Національність персонажа
     * @param string|null $residence Місце проживання персонажа
     * @param string|null $biography Біографія персонажа
     * @param array|Collection|null $funFacts Цікаві факти
     * @param array|Collection|null $links Посилання, пов'язані з персонажем
     * @param array|Collection|null $mediaImages Зображення персонажа
     */
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
        public readonly array|Collection|null $mediaImages = null,
    ) {}

    /**
     * Створити CharacterStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            bookId: $request->input('book_id'),
            name: $request->input('name'),
            otherNames: self::processJsonArray($request->input('other_names')),
            race: $request->input('race'),
            nationality: $request->input('nationality'),
            residence: $request->input('residence'),
            biography: $request->input('biography'),
            funFacts: self::processJsonArray($request->input('fun_facts')),
            links: self::processJsonArray($request->input('links')),
            mediaImages: self::processJsonArray($request->input('media_images')),
        );
    }
}
