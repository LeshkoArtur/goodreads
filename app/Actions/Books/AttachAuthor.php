<?php

namespace App\Actions\Books;

use App\Models\Author;
use App\Models\Book;
use Lorisleiva\Actions\Concerns\AsAction;

class AttachAuthor
{
    use AsAction;

    public function handle(Book $book, Author $author): bool
    {
        if ($book->authors()->where('author_id', $author->id)->exists()) {
            return false;
        }

        $book->authors()->attach($author->id);

        return true;
    }
}
