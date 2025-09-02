<?php

namespace App\Actions\NominationEntries;

use App\DTOs\NominationEntry\NominationEntryStoreDTO;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNominationEntry
{
    use AsAction;

    /**
     * Створити новий запис номінації.
     *
     * @param NominationEntryStoreDTO $dto
     * @return NominationEntry
     */
    public function handle(NominationEntryStoreDTO $dto): NominationEntry
    {
        $nominationEntry = new NominationEntry();
        $nominationEntry->nomination_id = $dto->nominationId;
        $nominationEntry->book_id = $dto->bookId;
        $nominationEntry->author_id = $dto->authorId;
        $nominationEntry->status = $dto->status?->value;

        $nominationEntry->save();

        return $nominationEntry->load(['nomination', 'book', 'author']);
    }
}
