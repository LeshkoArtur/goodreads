<?php

namespace App\Actions\Shelves;

use App\Models\Shelf;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class BulkRemoveBooksFromShelf
{
    use AsAction;

    public function handle(Shelf $shelf, array $bookIds, User $user): int
    {
        return $shelf->userBooks()
            ->where('user_id', $user->id)
            ->whereIn('book_id', $bookIds)
            ->delete();
    }
}
