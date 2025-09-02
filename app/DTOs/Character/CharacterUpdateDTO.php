<?php

namespace App\DTOs\Character;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних персонажа.
 */
class CharacterUpdateDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр CharacterUpdateDTO.
     *
     * @param string|null $name Ім’я персонажа
     * @param string|null $race Раса персонажа
     * @param string|null $nationality Національність персонажа
     * @param string|null $residence Місце проживання персонажа
     * @param array|null $otherNames Інші імена персонажа
     * @param string|null $description Опис персонажа
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $race = null,
        public readonly ?string $nationality = null,
        public readonly ?string $residence = null,
        public readonly ?array $otherNames = null,
        public readonly ?string $description = null,
    ) {
    }

    /**
     * Створює новий екземпляр DTO з запиту.
     *
     * @param Request $request HTTP-запит
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            name: $request->input('name'),
            race: $request->input('race'),
            nationality: $request->input('nationality'),
            residence: $request->input('residence'),
            otherNames: self::processArrayInput($request, 'other_names'),
            description: $request->input('description'),
        );
    }
}
