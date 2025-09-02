<?php

namespace App\Actions\Genres;

use App\DTOs\Genre\GenreUpdateDTO;
use App\Models\Genre;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGenre
{
    use AsAction;

    /**
     * Оновити існуючий жанр.
     *
     * @param Genre $genre
     * @param GenreUpdateDTO $dto
     * @return Genre
     */
    public function handle(Genre $genre, GenreUpdateDTO $dto): Genre
    {
        $attributes = [
            'name' => $dto->name,
            'parent_id' => $dto->parentId,
            'description' => $dto->description,
        ];

        $genre->fill(array_filter($attributes, fn($value) => $value !== null));

        $genre->save();

        return $genre->load(['books', 'parent', 'children']);
    }
}
