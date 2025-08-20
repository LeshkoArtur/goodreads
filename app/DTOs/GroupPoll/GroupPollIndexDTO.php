<?php

namespace App\DTOs\GroupPoll;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку опитувань груп.
 */
class GroupPollIndexDTO
{
    /**
     * Створює новий екземпляр GroupPollIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $groupId Фільтр за ID групи
     * @param string|null $creatorId Фільтр за ID творця
     * @param bool|null $isActive Фільтр за активністю
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $groupId = null,
        public readonly ?string $creatorId = null,
        public readonly ?bool $isActive = null,
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
            creatorId: $request->input('creator_id'),
            isActive: $request->has('is_active') ? (bool) $request->input('is_active') : null,
        );
    }
}
