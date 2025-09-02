<?php

namespace App\DTOs\GroupPoll;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних опитування групи.
 */
class GroupPollUpdateDTO
{
    /**
     * Створює новий екземпляр GroupPollUpdateDTO.
     *
     * @param string|null $title Назва опитування
     * @param string|null $description Опис опитування
     * @param bool|null $isActive Статус активності
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?bool $isActive = null,
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
            title: $request->input('title'),
            description: $request->input('description'),
            isActive: $request->has('is_active') ? $request->boolean('is_active') : null,
        );
    }
}
