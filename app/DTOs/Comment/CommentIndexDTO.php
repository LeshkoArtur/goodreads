<?php

namespace App\DTOs\Comment;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку коментарів.
 */
class CommentIndexDTO
{
    /**
     * Створює новий екземпляр CommentIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $userId Фільтр за ID користувача
     * @param string|null $commentableType Фільтр за типом коментованого об’єкта
     * @param string|null $commentableId Фільтр за ID коментованого об’єкта
     * @param bool|null $isRoot Фільтр за статусом кореня (не відповіді)
     * @param string|null $parentId Фільтр за ID батьківського коментаря
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $userId = null,
        public readonly ?string $commentableType = null,
        public readonly ?string $commentableId = null,
        public readonly ?bool $isRoot = null,
        public readonly ?string $parentId = null,
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
            commentableType: $request->input('commentable_type'),
            commentableId: $request->input('commentable_id'),
            isRoot: $request->has('is_root') ? (bool) $request->input('is_root') : null,
            parentId: $request->input('parent_id'),
        );
    }
}
