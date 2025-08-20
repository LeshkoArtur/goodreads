<?php

namespace App\DTOs\Genre;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку жанрів.
 */
class GenreIndexDTO
{
    /**
     * Створює новий екземпляр GenreIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $parentId Фільтр за ID батьківського жанру
     * @param int|null $minBookCount Мінімальна кількість книг
     * @param int|null $maxBookCount Максимальна кількість книг
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $parentId = null,
        public readonly ?int $minBookCount = null,
        public readonly ?int $maxBookCount = null,
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
            parentId: $request->input('parent_id'),
            minBookCount: $request->input('min_book_count') ? (int) $request->input('min_book_count') : null,
            maxBookCount: $request->input('max_book_count') ? (int) $request->input('max_book_count') : null,
        );
    }
}
