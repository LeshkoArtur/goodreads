<?php

namespace App\DTOs\ReadingStat;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку статистики читання.
 */
class ReadingStatIndexDTO
{
    /**
     * Створює новий екземпляр ReadingStatIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $userId Фільтр за ID користувача
     * @param string|null $bookId Фільтр за ID книги
     * @param string|null $status Фільтр за статусом читання
     * @param int|null $minPagesRead Мінімальна кількість прочитаних сторінок
     * @param int|null $maxPagesRead Максимальна кількість прочитаних сторінок
     * @param string|null $minStartDate Мінімальна дата початку читання
     * @param string|null $maxStartDate Максимальна дата початку читання
     * @param string|null $minFinishDate Мінімальна дата завершення читання
     * @param string|null $maxFinishDate Максимальна дата завершення читання
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $userId = null,
        public readonly ?string $bookId = null,
        public readonly ?string $status = null,
        public readonly ?int $minPagesRead = null,
        public readonly ?int $maxPagesRead = null,
        public readonly ?string $minStartDate = null,
        public readonly ?string $maxStartDate = null,
        public readonly ?string $minFinishDate = null,
        public readonly ?string $maxFinishDate = null,
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
            status: $request->input('status'),
            minPagesRead: $request->input('min_pages_read') ? (int) $request->input('min_pages_read') : null,
            maxPagesRead: $request->input('max_pages_read') ? (int) $request->input('max_pages_read') : null,
            minStartDate: $request->input('min_start_date'),
            maxStartDate: $request->input('max_start_date'),
            minFinishDate: $request->input('min_finish_date'),
            maxFinishDate: $request->input('max_finish_date'),
        );
    }
}
