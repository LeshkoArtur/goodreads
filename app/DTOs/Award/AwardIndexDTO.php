<?php

namespace App\DTOs\Award;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку нагород.
 */
class AwardIndexDTO
{
    /**
     * Створює новий екземпляр AwardIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param int|null $year Фільтр за роком
     * @param string|null $organizer Фільтр за організатором
     * @param string|null $country Фільтр за країною
     * @param string|null $minCeremonyDate Мінімальна дата церемонії
     * @param string|null $maxCeremonyDate Максимальна дата церемонії
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?int $year = null,
        public readonly ?string $organizer = null,
        public readonly ?string $country = null,
        public readonly ?string $minCeremonyDate = null,
        public readonly ?string $maxCeremonyDate = null,
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
            year: $request->input('year') ? (int) $request->input('year') : null,
            organizer: $request->input('organizer'),
            country: $request->input('country'),
            minCeremonyDate: $request->input('min_ceremony_date'),
            maxCeremonyDate: $request->input('max_ceremony_date'),
        );
    }
}
