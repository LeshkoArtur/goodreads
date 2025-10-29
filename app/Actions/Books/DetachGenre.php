<?php

namespace App\Actions\Books;

use App\Models\Book;
use App\Models\Genre;
use Lorisleiva\Actions\Concerns\AsAction;

class DetachGenre
{
    use AsAction;

    public function handle(Book $book, Genre $genre): bool
    {
        if (! $book->genres()->where('genre_id', $genre->id)->exists()) {
            return false;
        }

        $book->genres()->detach($genre->id);

        return true;
    }
}
