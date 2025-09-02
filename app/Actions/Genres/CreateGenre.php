<?php

namespace App\Actions\Genres;

use App\DTOs\Genre\GenreStoreDTO;
use App\Models\Genre;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGenre
{
    use AsAction;

    /**
     * Створити новий жанр.
     *
     * @param GenreStoreDTO $dto
     * @return Genre
     */
    public function handle(GenreStoreDTO $dto): Genre
    {
        $genre = new Genre();
        $genre->name = $dto->name;
        $genre->parent_id = $dto->parentId;
        $genre->description = $dto->description;
        $genre->book_count = $dto->bookCount;

        $genre->save();

        return $genre->load(['books', 'parent', 'children']);
    }
}
