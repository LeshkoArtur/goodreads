<?php

namespace App\DTOs\GroupModerationLog;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних логу модерації групи.
 */
class GroupModerationLogUpdateDTO
{
    /**
     * Створює новий екземпляр GroupModerationLogUpdateDTO.
     *
     * @param string|null $action Дія модерації
     * @param string|null $description Опис дії
     */
    public function __construct(
        public readonly ?string $action = null,
        public readonly ?string $description = null,
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
            action: $request->input('action'),
            description: $request->input('description'),
        );
    }
}
