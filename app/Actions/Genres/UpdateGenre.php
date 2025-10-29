<?php

namespace App\Actions\Genres;

use App\Data\Genre\GenreUpdateData;
use App\Models\Genre;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGenre
{
    use AsAction;

    public function handle(Genre $genre, GenreUpdateData $data): Genre
    {
        $genre->update(array_filter([
            'name' => $data->name,
            'parent_id' => $data->parent_id,
            'description' => $data->description,
            'book_count' => $data->book_count,
        ], fn ($value) => $value !== null));

        return $genre->fresh(['books', 'parent', 'children']);
    }
}
