<?php

namespace App\DTOs\ViewHistory;

use Illuminate\Http\Request;

class ViewHistoryStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $viewableId ID об'єкта перегляду
     * @param string $viewableType Тип об'єкта перегляду
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $viewableId,
        public readonly string $viewableType
    ) {}

    /**
     * Створити ViewHistoryStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            viewableId: $request->input('viewable_id'),
            viewableType: $request->input('viewable_type')
        );
    }
}
