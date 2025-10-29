<?php

namespace App\Actions\NominationEntries;

use App\Models\Award;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationEntryAward
{
    use AsAction;

    public function handle(NominationEntry $entry): Award
    {
        return $entry->nomination->award;
    }
}
