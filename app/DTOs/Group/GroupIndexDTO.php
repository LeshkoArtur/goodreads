<?php

namespace App\DTOs\Group;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку груп.
 */
class GroupIndexDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр GroupIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $creatorId Фільтр за ID творця
     * @param bool|null $isPublic Фільтр за видимістю групи
     * @param bool|null $isActive Фільтр за активністю групи
     * @param string|null $joinPolicy Фільтр за політикою приєднання
     * @param string|null $postPolicy Фільтр за політикою публікацій
     * @param int|null $minMemberCount Мінімальна кількість учасників
     * @param int|null $maxMemberCount Максимальна кількість учасників
     * @param array|null $memberIds Фільтр за ID учасників
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $creatorId = null,
        public readonly ?bool $isPublic = null,
        public readonly ?bool $isActive = null,
        public readonly ?string $joinPolicy = null,
        public readonly ?string $postPolicy = null,
        public readonly ?int $minMemberCount = null,
        public readonly ?int $maxMemberCount = null,
        public readonly ?array $memberIds = null,
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
            creatorId: $request->input('creator_id'),
            isPublic: $request->has('is_public') ? (bool) $request->input('is_public') : null,
            isActive: $request->has('is_active') ? (bool) $request->input('is_active') : null,
            joinPolicy: $request->input('join_policy'),
            postPolicy: $request->input('post_policy'),
            minMemberCount: $request->input('min_member_count') ? (int) $request->input('min_member_count') : null,
            maxMemberCount: $request->input('max_member_count') ? (int) $request->input('max_member_count') : null,
            memberIds: self::processArrayInput($request, 'member_ids'),
        );
    }
}
