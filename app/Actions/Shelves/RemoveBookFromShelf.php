<?php

namespace App\Actions\Shelves;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class RemoveBookFromShelf
{
    use AsAction;

    public function handle(Shelf $shelf, Book $book, User $user): bool
    {
        $userBook = $shelf->userBooks()
            ->where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->first();

        if (! $userBook) {
            return false;
        }

        $userBook->delete();

        return true;
    }
}
