<?php

namespace App\DTOs\User;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для фільтрації списку користувачів.
 */
class UserIndexDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр UserIndexDTO.
     *
     * @param string|null $query Пошуковий запит
     * @param int $page Номер поточної сторінки
     * @param int $perPage Кількість елементів на сторінці
     * @param string|null $sort Поле для сортування
     * @param string $direction Напрямок сортування (asc або desc)
     * @param string|null $role Фільтр за роллю (user, admin)
     * @param string|null $gender Фільтр за статтю
     * @param bool|null $isPublic Фільтр за видимістю профілю
     * @param string|null $location Фільтр за місцем розташування
     * @param array|null $socialMediaLinks Фільтр за соціальними мережами
     * @param string|null $minBirthday Мінімальна дата народження
     * @param string|null $maxBirthday Максимальна дата народження
     * @param string|null $minLastLogin Мінімальний час останнього входу
     * @param string|null $maxLastLogin Максимальний час останнього входу
     */
    public function __construct(
        public readonly ?string $query = null,
        public readonly int $page = 1,
        public readonly int $perPage = 15,
        public readonly ?string $sort = 'created_at',
        public readonly string $direction = 'desc',
        public readonly ?string $role = null,
        public readonly ?string $gender = null,
        public readonly ?bool $isPublic = null,
        public readonly ?string $location = null,
        public readonly ?array $socialMediaLinks = null,
        public readonly ?string $minBirthday = null,
        public readonly ?string $maxBirthday = null,
        public readonly ?string $minLastLogin = null,
        public readonly ?string $maxLastLogin = null,
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
            role: $request->input('role'),
            gender: $request->input('gender'),
            isPublic: $request->has('is_public') ? (bool) $request->input('is_public') : null,
            location: $request->input('location'),
            socialMediaLinks: self::processArrayInput($request, 'social_media_links'),
            minBirthday: $request->input('min_birthday'),
            maxBirthday: $request->input('max_birthday'),
            minLastLogin: $request->input('min_last_login'),
            maxLastLogin: $request->input('max_last_login'),
        );
    }
}
