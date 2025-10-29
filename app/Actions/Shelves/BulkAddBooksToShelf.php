<?php

namespace App\Actions\Shelves;

use App\Models\Shelf;
use App\Models\User;
use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class BulkAddBooksToShelf
{
    use AsAction;

    public function handle(Shelf $shelf, array $bookIds, User $user): int
    {
        $count = 0;

        foreach ($bookIds as $bookId) {
            $userBook = UserBook::firstOrCreate([
                'user_id' => $user->id,
                'book_id' => $bookId,
            ], [
                'shelf_id' => $shelf->id,
            ]);

            if ($userBook->shelf_id !== $shelf->id) {
                $userBook->update(['shelf_id' => $shelf->id]);
            }

            $count++;
        }

        return $count;
    }
}
