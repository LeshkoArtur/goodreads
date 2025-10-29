<?php

namespace App\Actions\NominationEntries;

use App\Data\NominationEntry\NominationEntryUpdateData;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateNominationEntry
{
    use AsAction;

    public function handle(NominationEntry $entry, NominationEntryUpdateData $data): NominationEntry
    {
        if ($data->book_id !== null) {
            $entry->book_id = $data->book_id;
        }

        if ($data->author_id !== null) {
            $entry->author_id = $data->author_id;
        }

        if ($data->status !== null) {
            $entry->status = $data->status;
        }

        $entry->save();

        return $entry->fresh(['nomination', 'book', 'author']);
    }
}
