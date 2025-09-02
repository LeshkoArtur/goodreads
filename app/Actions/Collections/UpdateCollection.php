<?php

namespace App\Actions\Collections;

use App\DTOs\Collection\CollectionUpdateDTO;
use App\Models\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCollection
{
    use AsAction;

    /**
     * Оновити існуючу колекцію.
     *
     * @param Collection $collection
     * @param CollectionUpdateDTO $dto
     * @return Collection
     */
    public function handle(Collection $collection, CollectionUpdateDTO $dto): Collection
    {
        $attributes = [
            'title' => $dto->name,
            'is_public' => $dto->isPublic,
            'description' => $dto->description,
        ];

        $collection->fill(array_filter($attributes, fn($value) => $value !== null));

        $collection->save();

        return $collection->load(['user', 'books']);
    }
}
