<?php

namespace App\Actions\Characters;

use App\DTOs\Character\CharacterUpdateDTO;
use App\Models\Character;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCharacter
{
    use AsAction;

    /**
     * Оновити існуючого персонажа.
     *
     * @param Character $character
     * @param CharacterUpdateDTO $dto
     * @return Character
     */
    public function handle(Character $character, CharacterUpdateDTO $dto): Character
    {
        $attributes = [
            'name' => $dto->name,
            'race' => $dto->race,
            'nationality' => $dto->nationality,
            'residence' => $dto->residence,
            'other_names' => $dto->otherNames,
            'biography' => $dto->description,
        ];

        $character->fill(array_filter($attributes, fn($value) => $value !== null));

        $character->save();

        return $character->load(['book']);
    }
}
