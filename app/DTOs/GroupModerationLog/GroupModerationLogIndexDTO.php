<?php

namespace App\DTOs\GroupModerationLog;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку логів модерації груп.
 */
class GroupModerationLogIndexDTO
{
    /**
     * Створює новий екземпляр GroupModerationLogIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $groupId Фільтр за ID групи
     * @param string|null $moderatorId Фільтр за ID модератора
     * @param string|null $action Фільтр за дією
     * @param string|null $targetableType Фільтр за типом цільового об’єкта
     * @param string|null $targetableId Фільтр за ID цільового об’єкта
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $groupId = null,
        public readonly ?string $moderatorId = null,
        public readonly ?string $action = null,
        public readonly ?string $targetableType = null,
        public readonly ?string $targetableId = null,
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
            groupId: $request->input('group_id'),
            moderatorId: $request->input('moderator_id'),
            action: $request->input('action'),
            targetableType: $request->input('targetable_type'),
            targetableId: $request->input('targetable_id'),
        );
    }
}
