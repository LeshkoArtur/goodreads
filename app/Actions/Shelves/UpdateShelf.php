<?php

namespace App\Actions\Shelves;

use App\Data\Shelf\ShelfUpdateData;
use App\Models\Shelf;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateShelf
{
    use AsAction;

    public function handle(Shelf $shelf, ShelfUpdateData $data): Shelf
    {
        $shelf->update(array_filter([
            'user_id' => $data->user_id,
            'name' => $data->name,
        ], fn ($value) => $value !== null));

        return $shelf->fresh(['user', 'userBooks']);
    }
}
