<?php

namespace App\DTOs\Store;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку магазинів.
 */
class StoreIndexDTO
{
    /**
     * Створює новий екземпляр StoreIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $country Фільтр за країною
     * @param string|null $type Фільтр за типом магазину
     * @param bool|null $isOnline Фільтр за онлайн/офлайн статусом
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $country = null,
        public readonly ?string $type = null,
        public readonly ?bool $isOnline = null,
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
            country: $request->input('country'),
            type: $request->input('type'),
            isOnline: $request->has('is_online') ? (bool) $request->input('is_online') : null,
        );
    }
}
