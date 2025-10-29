<?php

namespace App\Actions\Books;

use App\Models\Book;
use App\Models\Publisher;
use Lorisleiva\Actions\Concerns\AsAction;

class DetachPublisher
{
    use AsAction;

    public function handle(Book $book, Publisher $publisher): bool
    {
        if (! $book->publishers()->where('publisher_id', $publisher->id)->exists()) {
            return false;
        }

        $book->publishers()->detach($publisher->id);

        return true;
    }
}
