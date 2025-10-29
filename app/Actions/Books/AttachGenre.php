<?php

namespace App\Actions\Books;

use App\Models\Book;
use App\Models\Genre;
use Lorisleiva\Actions\Concerns\AsAction;

class AttachGenre
{
    use AsAction;

    public function handle(Book $book, Genre $genre): bool
    {
        if ($book->genres()->where('genre_id', $genre->id)->exists()) {
            return false;
        }

        $book->genres()->attach($genre->id);

        return true;
    }
}
