<?php

namespace App\Actions\UserBooks;

use App\DTOs\UserBook\UserBookUpdateDTO;
use App\Models\UserBook;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateUserBook
{
    use AsAction;

    /**
     * Оновити існуючий зв’язок між користувачем та книгою.
     *
     * @param UserBook $userBook
     * @param UserBookUpdateDTO $dto
     * @return UserBook
     */
    public function handle(UserBook $userBook, UserBookUpdateDTO $dto): UserBook
    {
        $attributes = [
            'shelf_id' => $dto->shelfId,
        ];

        $userBook->fill(array_filter($attributes, fn($value) => $value !== null));

        $userBook->save();

        return $userBook->load(['user', 'book', 'shelf']);
    }
}
