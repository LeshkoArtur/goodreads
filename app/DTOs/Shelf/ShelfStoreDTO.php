<?php

namespace App\DTOs\Shelf;

use Illuminate\Http\Request;

class ShelfStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $name Назва полиці
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $name
    ) {}

    /**
     * Створити ShelfStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            name: $request->input('name')
        );
    }
}
