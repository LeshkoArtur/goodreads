<?php

namespace App\Actions\NominationEntries;

use App\Models\Nomination;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationEntryNomination
{
    use AsAction;

    public function handle(NominationEntry $entry): Nomination
    {
        return $entry->nomination;
    }
}
