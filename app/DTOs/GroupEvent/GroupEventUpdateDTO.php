<?php

namespace App\DTOs\GroupEvent;

use App\Enums\EventStatus;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних події групи.
 */
class GroupEventUpdateDTO
{
    /**
     * Створює новий екземпляр GroupEventUpdateDTO.
     *
     * @param string|null $title Назва події
     * @param string|null $description Опис події
     * @param string|null $eventDate Дата події
     * @param string|null $location Місце проведення
     * @param string|null $status Статус події
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?string $eventDate = null,
        public readonly ?string $location = null,
        public readonly ?string $status = null,
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
            eventDate: $request->input('event_date'),
            location: $request->input('location'),
            status: $request->input('status'),
        );
    }
}
