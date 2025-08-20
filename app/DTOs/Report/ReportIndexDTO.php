<?php

namespace App\DTOs\Report;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку звітів.
 */
class ReportIndexDTO
{
    /**
     * Створює новий екземпляр ReportIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $userId Фільтр за ID користувача
     * @param string|null $reportableType Фільтр за типом об’єкта звіту
     * @param string|null $reportableId Фільтр за ID об’єкта звіту
     * @param string|null $reason Фільтр за причиною звіту
     * @param string|null $status Фільтр за статусом
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $userId = null,
        public readonly ?string $reportableType = null,
        public readonly ?string $reportableId = null,
        public readonly ?string $reason = null,
        public readonly ?string $status = null,
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
            reportableType: $request->input('reportable_type'),
            reportableId: $request->input('reportable_id'),
            reason: $request->input('reason'),
            status: $request->input('status'),
        );
    }
}
