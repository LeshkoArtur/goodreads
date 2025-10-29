<?php

namespace App\Actions\NominationEntries;

use App\Enums\NominationStatus;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class RejectNominationEntry
{
    use AsAction;

    public function handle(NominationEntry $entry): NominationEntry
    {
        $entry->status = NominationStatus::REJECTED;
        $entry->save();

        return $entry->fresh(['nomination', 'book', 'author']);
    }
}
