<?php

namespace App\DTOs\BookOffer;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку пропозицій книг.
 */
class BookOfferIndexDTO
{
    /**
     * Створює новий екземпляр BookOfferIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $bookId Фільтр за ID книги
     * @param string|null $storeId Фільтр за ID магазину
     * @param float|null $minPrice Мінімальна ціна
     * @param float|null $maxPrice Максимальна ціна
     * @param string|null $currency Фільтр за валютою
     * @param string|null $status Фільтр за статусом
     * @param string|null $minLastUpdatedAt Мінімальний час останнього оновлення
     * @param string|null $maxLastUpdatedAt Максимальний час останнього оновлення
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $bookId = null,
        public readonly ?string $storeId = null,
        public readonly ?float $minPrice = null,
        public readonly ?float $maxPrice = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
        public readonly ?string $minLastUpdatedAt = null,
        public readonly ?string $maxLastUpdatedAt = null,
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
            bookId: $request->input('book_id'),
            storeId: $request->input('store_id'),
            minPrice: $request->input('min_price') ? (float) $request->input('min_price') : null,
            maxPrice: $request->input('max_price') ? (float) $request->input('max_price') : null,
            currency: $request->input('currency'),
            status: $request->input('status'),
            minLastUpdatedAt: $request->input('min_last_updated_at'),
            maxLastUpdatedAt: $request->input('max_last_updated_at'),
        );
    }
}
