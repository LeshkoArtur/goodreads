<?php

namespace App\Actions\Shelves;

use App\Data\Shelf\ShelfStoreData;
use App\Models\Shelf;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateShelf
{
    use AsAction;

    public function handle(ShelfStoreData $data): Shelf
    {
        $shelf = new Shelf;
        $shelf->user_id = $data->user_id;
        $shelf->name = $data->name;
        $shelf->save();

        return $shelf->fresh(['user', 'userBooks']);
    }
}
