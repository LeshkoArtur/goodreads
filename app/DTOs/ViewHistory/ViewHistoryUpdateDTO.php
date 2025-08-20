<?php

namespace App\DTOs\ViewHistory;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних історії переглядів.
 */
class ViewHistoryUpdateDTO
{
    /**
     * Створює новий екземпляр ViewHistoryUpdateDTO.
     *
     * @param string|null $viewableType Тип переглянутого об’єкта
     * @param string|null $viewableId ID переглянутого об’єкта
     * @param string|null $viewedAt Час перегляду
     */
    public function __construct(
        public readonly ?string $viewableType = null,
        public readonly ?string $viewableId = null,
        public readonly ?string $viewedAt = null,
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
            viewableType: $request->input('viewable_type'),
            viewableId: $request->input('viewable_id'),
            viewedAt: $request->input('viewed_at'),
        );
    }
}
