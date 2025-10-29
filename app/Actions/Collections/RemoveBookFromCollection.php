<?php

namespace App\Actions\Collections;

use App\Models\Book;
use App\Models\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class RemoveBookFromCollection
{
    use AsAction;

    public function handle(Collection $collection, Book $book): bool
    {
        if (! $collection->books()->where('book_id', $book->id)->exists()) {
            return false;
        }

        $collection->books()->detach($book->id);

        return true;
    }
}
