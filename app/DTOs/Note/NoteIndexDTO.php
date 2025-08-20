<?php

namespace App\DTOs\Note;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку нотаток.
 */
class NoteIndexDTO
{
    /**
     * Створює новий екземпляр NoteIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $userId Фільтр за ID користувача
     * @param string|null $bookId Фільтр за ID книги
     * @param bool|null $containsSpoilers Фільтр за наявністю спойлерів
     * @param bool|null $isPrivate Фільтр за приватністю
     * @param int|null $minPageNumber Мінімальний номер сторінки
     * @param int|null $maxPageNumber Максимальний номер сторінки
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $userId = null,
        public readonly ?string $bookId = null,
        public readonly ?bool $containsSpoilers = null,
        public readonly ?bool $isPrivate = null,
        public readonly ?int $minPageNumber = null,
        public readonly ?int $maxPageNumber = null,
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
            userId: $request->input('user_id'),
            bookId: $request->input('book_id'),
            containsSpoilers: $request->has('contains_spoilers') ? (bool) $request->input('contains_spoilers') : null,
            isPrivate: $request->has('is_private') ? (bool) $request->input('is_private') : null,
            minPageNumber: $request->input('min_page_number') ? (int) $request->input('min_page_number') : null,
            maxPageNumber: $request->input('max_page_number') ? (int) $request->input('max_page_number') : null,
        );
    }
}
