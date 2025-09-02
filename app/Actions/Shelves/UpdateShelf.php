<?php

namespace App\Actions\Shelves;

use App\DTOs\Shelf\ShelfUpdateDTO;
use App\Models\Shelf;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateShelf
{
    use AsAction;

    /**
     * Оновити існуючу полицю.
     *
     * @param Shelf $shelf
     * @param ShelfUpdateDTO $dto
     * @return Shelf
     */
    public function handle(Shelf $shelf, ShelfUpdateDTO $dto): Shelf
    {
        $attributes = [
            'name' => $dto->name,
        ];

        $shelf->fill(array_filter($attributes, fn($value) => $value !== null));

        $shelf->save();

        return $shelf->load(['user', 'userBooks']);
    }
}
