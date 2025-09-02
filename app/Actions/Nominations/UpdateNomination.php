<?php

namespace App\Actions\Nominations;

use App\DTOs\Nomination\NominationUpdateDTO;
use App\Models\Nomination;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateNomination
{
    use AsAction;

    /**
     * Оновити існуючу номінацію.
     *
     * @param Nomination $nomination
     * @param NominationUpdateDTO $dto
     * @return Nomination
     */
    public function handle(Nomination $nomination, NominationUpdateDTO $dto): Nomination
    {
        $attributes = [
            'name' => $dto->name,
            'description' => $dto->description,
        ];

        $nomination->fill(array_filter($attributes, fn($value) => $value !== null));

        $nomination->save();

        return $nomination->load(['award', 'entries']);
    }
}
