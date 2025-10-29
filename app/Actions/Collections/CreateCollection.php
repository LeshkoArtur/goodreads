<?php

namespace App\Actions\Collections;

use App\Data\Collection\CollectionStoreData;
use App\Models\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCollection
{
    use AsAction;

    public function handle(CollectionStoreData $data): Collection
    {
        $collection = new Collection;
        $collection->user_id = $data->user_id;
        $collection->title = $data->title;
        $collection->description = $data->description;
        $collection->cover_image = $data->cover_image;
        $collection->is_public = $data->is_public;
        $collection->save();

        when($data->book_ids, fn () => $collection->books()->sync($data->book_ids));

        return $collection->fresh(['user', 'books']);
    }
}
