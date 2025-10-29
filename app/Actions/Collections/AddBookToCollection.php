<?php

namespace App\Actions\Collections;

use App\Models\Book;
use App\Models\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class AddBookToCollection
{
    use AsAction;

    public function handle(Collection $collection, Book $book, ?int $orderIndex = null): bool
    {
        if ($collection->books()->where('book_id', $book->id)->exists()) {
            return false;
        }

        $orderIndex = $orderIndex ?? ($collection->books()->max('order_index') ?? 0) + 1;

        $collection->books()->attach($book->id, ['order_index' => $orderIndex]);

        return true;
    }
}
