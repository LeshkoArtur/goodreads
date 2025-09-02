<?php

namespace App\DTOs\BookSeries;

use Illuminate\Http\Request;

/**
 * DTO для оновлення даних книжкової серії.
 */
class BookSeriesUpdateDTO
{
    /**
     * Створює новий екземпляр BookSeriesUpdateDTO.
     *
     * @param string|null $title Назва серії
     * @param bool|null $isCompleted Статус завершення серії
     * @param string|null $description Опис серії
     */
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?bool $isCompleted = null,
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
            title: $request->input('title'),
            isCompleted: $request->has('is_completed') ? $request->boolean('is_completed') : null,
            description: $request->input('description'),
        );
    }
}
