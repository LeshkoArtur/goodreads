<?php

namespace App\Actions\NominationEntries;

use App\DTOs\NominationEntry\NominationEntryUpdateDTO;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateNominationEntry
{
    use AsAction;

    /**
     * Оновити існуючий запис номінації.
     *
     * @param NominationEntry $nominationEntry
     * @param NominationEntryUpdateDTO $dto
     * @return NominationEntry
     */
    public function handle(NominationEntry $nominationEntry, NominationEntryUpdateDTO $dto): NominationEntry
    {
        $attributes = [
            'status' => $dto->status,
        ];

        $nominationEntry->fill(array_filter($attributes, fn($value) => $value !== null));

        $nominationEntry->save();

        return $nominationEntry->load(['nomination', 'book', 'author']);
    }
}
