<?php

namespace App\Actions\NominationEntries;

use App\Models\Author;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationEntryAuthor
{
    use AsAction;

    public function handle(NominationEntry $entry): ?Author
    {
        return $entry->author;
    }
}
