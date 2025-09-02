<?php

namespace App\DTOs\ViewHistory;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку історії переглядів.
 */
class ViewHistoryIndexDTO
{
    /**
     * Створює новий екземпляр ViewHistoryIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $userId Фільтр за ID користувача
     * @param string|null $viewableType Фільтр за типом переглянутого об’єкта
     * @param string|null $viewableId Фільтр за ID переглянутого об’єкта
     * @param string|null $minViewedAt Мінімальний час перегляду
     * @param string|null $maxViewedAt Максимальний час перегляду
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $userId = null,
        public readonly ?string $viewableType = null,
        public readonly ?string $viewableId = null,
        public readonly ?string $minViewedAt = null,
        public readonly ?string $maxViewedAt = null,
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
            viewableType: $request->input('viewable_type'),
            viewableId: $request->input('viewable_id'),
            minViewedAt: $request->input('min_viewed_at'),
            maxViewedAt: $request->input('max_viewed_at'),
        );
    }
}
