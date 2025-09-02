<?php

namespace App\DTOs\Tag;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку тегів.
 */
class TagIndexDTO
{
    /**
     * Створює новий екземпляр TagIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param int|null $minUsageCount Мінімальна кількість використань
     * @param int|null $maxUsageCount Максимальна кількість використань
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?int $minUsageCount = null,
        public readonly ?int $maxUsageCount = null,
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
            minUsageCount: $request->input('min_usage_count') ? (int) $request->input('min_usage_count') : null,
            maxUsageCount: $request->input('max_usage_count') ? (int) $request->input('max_usage_count') : null,
        );
    }
}
