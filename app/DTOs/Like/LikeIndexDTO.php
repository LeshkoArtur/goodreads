<?php

namespace App\DTOs\Like;

use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку лайків.
 */
class LikeIndexDTO
{
    /**
     * Створює новий екземпляр LikeIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $userId Фільтр за ID користувача
     * @param string|null $likeableType Фільтр за типом лайкнутого об’єкта
     * @param string|null $likeableId Фільтр за ID лайкнутого об’єкта
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $userId = null,
        public readonly ?string $likeableType = null,
        public readonly ?string $likeableId = null,
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
            likeableType: $request->input('likeable_type'),
            likeableId: $request->input('likeable_id'),
        );
    }
}
