<?php

namespace App\DTOs\BookSeries;

use Illuminate\Http\Request;

class BookSeriesStoreDTO
{
    /**
     * @param string $title Назва серії
     * @param string|null $description Опис серії
     * @param int|null $totalBooks Загальна кількість книг у серії
     * @param bool|null $isCompleted Чи завершена серія
     */
    public function __construct(
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly ?int $totalBooks = null,
        public readonly ?bool $isCompleted = null,
    ) {}

    /**
     * Створити BookSeriesStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            title: $request->input('title'),
            description: $request->input('description'),
            totalBooks: $request->input('total_books') !== null ? (int)$request->input('total_books') : null,
            isCompleted: $request->has('is_completed') ? (bool)$request->input('is_completed') : null,
        );
    }
}
