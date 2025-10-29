<?php

namespace App\Actions\NominationEntries;

use App\Data\NominationEntry\NominationEntryStoreData;
use App\Enums\NominationStatus;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNominationEntry
{
    use AsAction;

    public function handle(NominationEntryStoreData $data): NominationEntry
    {
        $entry = new NominationEntry;
        $entry->nomination_id = $data->nomination_id;
        $entry->book_id = $data->book_id;
        $entry->author_id = $data->author_id;
        $entry->status = NominationStatus::PENDING;
        $entry->save();

        return $entry->fresh(['nomination', 'book', 'author']);
    }
}
