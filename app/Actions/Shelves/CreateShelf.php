<?php

namespace App\Actions\Shelves;

use App\DTOs\Shelf\ShelfStoreDTO;
use App\Models\Shelf;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateShelf
{
    use AsAction;

    /**
     * Створити нову полицю.
     *
     * @param ShelfStoreDTO $dto
     * @return Shelf
     */
    public function handle(ShelfStoreDTO $dto): Shelf
    {
        $shelf = new Shelf();
        $shelf->user_id = $dto->userId;
        $shelf->name = $dto->name;

        $shelf->save();

        return $shelf->load(['user', 'userBooks']);
    }
}
