<?php

namespace App\Actions\NominationEntries;

use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationEntryVoteCount
{
    use AsAction;

    public function handle(NominationEntry $entry): int
    {
        return $entry->votes()->count();
    }
}
