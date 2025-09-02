<?php

namespace App\Actions\Nominations;

use App\DTOs\Nomination\NominationStoreDTO;
use App\Models\Nomination;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNomination
{
    use AsAction;

    /**
     * Створити нову номінацію.
     *
     * @param NominationStoreDTO $dto
     * @return Nomination
     */
    public function handle(NominationStoreDTO $dto): Nomination
    {
        $nomination = new Nomination();
        $nomination->award_id = $dto->awardId;
        $nomination->name = $dto->name;
        $nomination->description = $dto->description;

        $nomination->save();

        return $nomination->load(['award', 'entries']);
    }
}
