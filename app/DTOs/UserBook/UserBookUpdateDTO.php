<?php

namespace App\DTOs\UserBook;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних зв’язку між користувачем та книгою.
 */
class UserBookUpdateDTO
{
    /**
     * Створює новий екземпляр UserBookUpdateDTO.
     *
     * @param string|null $shelfId ID полиці
     */
    public function __construct(
        public readonly ?string $shelfId = null,
    ) {
    }

    /**
     * Створює новий екземпляр DTO з запиту.
     *
     * @param Request $request HTTP-запит
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            shelfId: $request->input('shelf_id'),
        );
    }
}
