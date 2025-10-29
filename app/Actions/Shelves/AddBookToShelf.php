<?php

namespace App\Actions\Shelves;

use App\Models\Book;
use App\Models\Shelf;
use App\Models\User;
use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class AddBookToShelf
{
    use AsAction;

    public function handle(Shelf $shelf, Book $book, User $user): UserBook
    {
        $userBook = UserBook::firstOrCreate([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ], [
            'shelf_id' => $shelf->id,
        ]);

        if ($userBook->shelf_id !== $shelf->id) {
            $userBook->update(['shelf_id' => $shelf->id]);
        }

        return $userBook;
    }
}
