<?php

namespace App\DTOs\BookSeries;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку книжкових серій.
 */
class BookSeriesIndexDTO
{
    /**
     * Створює новий екземпляр BookSeriesIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param int|null $minTotalBooks Мінімальна кількість книг у серії
     * @param int|null $maxTotalBooks Максимальна кількість книг у серії
     * @param bool|null $isCompleted Фільтр за статусом завершення
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?int $minTotalBooks = null,
        public readonly ?int $maxTotalBooks = null,
        public readonly ?bool $isCompleted = null,
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
            query: $request->input('q'),
            page: (int) $request->input('page', 1),
            perPage: (int) $request->input('per_page', 15),
            sort: $request->input('sort', 'created_at'),
            direction: $request->input('direction', 'desc'),
            minTotalBooks: $request->input('min_total_books') ? (int) $request->input('min_total_books') : null,
            maxTotalBooks: $request->input('max_total_books') ? (int) $request->input('max_total_books') : null,
            isCompleted: $request->has('is_completed') ? (bool) $request->input('is_completed') : null,
        );
    }
}
