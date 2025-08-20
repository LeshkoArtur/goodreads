<?php

namespace App\DTOs\GroupPost;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку постів груп.
 */
class GroupPostIndexDTO
{
    /**
     * Створює новий екземпляр GroupPostIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $groupId Фільтр за ID групи
     * @param string|null $userId Фільтр за ID користувача
     * @param bool|null $isPinned Фільтр за статусом закріплення
     * @param string|null $category Фільтр за категорією
     * @param string|null $postStatus Фільтр за статусом
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $groupId = null,
        public readonly ?string $userId = null,
        public readonly ?bool $isPinned = null,
        public readonly ?string $category = null,
        public readonly ?string $postStatus = null,
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
            userId: $request->input('user_id'),
            isPinned: $request->has('is_pinned') ? (bool) $request->input('is_pinned') : null,
            category: $request->input('category'),
            postStatus: $request->input('post_status'),
        );
    }
}
