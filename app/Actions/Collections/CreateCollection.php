<?php

namespace App\Actions\Collections;

use App\DTOs\Collection\CollectionStoreDTO;
use App\Models\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCollection
{
    use AsAction;

    /**
     * Створити нову колекцію.
     *
     * @param CollectionStoreDTO $dto
     * @return Collection
     */
    public function handle(CollectionStoreDTO $dto): Collection
    {
        $collection = new Collection();
        $collection->user_id = $dto->userId;
        $collection->title = $dto->title;
        $collection->description = $dto->description;
        $collection->is_public = $dto->isPublic;

        if ($dto->coverImage) {
            $collection->cover_image = $collection->handleFileUpload($dto->coverImage, 'collection_covers');
        }

        $collection->save();

        return $collection->load(['user', 'books']);
    }
}
