<?php

namespace App\Actions\NominationEntries;

use App\Models\Book;
use App\Models\NominationEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class GetNominationEntryBook
{
    use AsAction;

    public function handle(NominationEntry $entry): ?Book
    {
        return $entry->book;
    }
}
