<?php

namespace App\Actions\Collections;

use App\Data\Collection\CollectionUpdateData;
use App\Models\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCollection
{
    use AsAction;

    public function handle(Collection $collection, CollectionUpdateData $data): Collection
    {
        $collection->update(array_filter([
            'user_id' => $data->user_id,
            'title' => $data->title,
            'description' => $data->description,
            'cover_image' => $data->cover_image,
            'is_public' => $data->is_public,
        ], fn ($value) => $value !== null));

        when($data->book_ids !== null, fn () => $collection->books()->sync($data->book_ids));

        return $collection->fresh(['user', 'books']);
    }
}
