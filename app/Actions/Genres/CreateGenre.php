<?php

namespace App\Actions\Genres;

use App\Data\Genre\GenreStoreData;
use App\Models\Genre;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateGenre
{
    use AsAction;

    public function handle(GenreStoreData $data): Genre
    {
        $genre = new Genre;
        $genre->name = $data->name;
        $genre->parent_id = $data->parent_id;
        $genre->description = $data->description;
        $genre->book_count = $data->book_count;
        $genre->save();

        return $genre->fresh(['books', 'parent', 'children']);
    }
}
