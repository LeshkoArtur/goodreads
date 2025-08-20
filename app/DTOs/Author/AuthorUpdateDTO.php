<?php

namespace App\DTOs\Author;

use App\DTOs\Traits\HandlesJsonArrays;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних автора.
 */
class AuthorUpdateDTO
{
    use HandlesJsonArrays;

    /**
     * Створює новий екземпляр AuthorUpdateDTO.
     *
     * @param string|null $name Ім’я автора
     * @param string|null $nationality Національність автора
     * @param string|null $birthDate Дата народження автора
     * @param string|null $deathDate Дата смерті автора
     * @param string|null $typeOfWork Тип роботи автора
     * @param array|null $socialMediaLinks Соціальні мережі автора
     * @param string|null $biography Біографія автора
     * @param array|null $userIds Масив ID користувачів
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $nationality = null,
        public readonly ?string $birthDate = null,
        public readonly ?string $deathDate = null,
        public readonly ?string $typeOfWork = null,
        public readonly ?array $socialMediaLinks = null,
        public readonly ?string $biography = null,
        public readonly ?array $userIds = null
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
            name: $request->input('name'),
            nationality: $request->input('nationality'),
            birthDate: $request->input('birth_date'),
            deathDate: $request->input('death_date'),
            typeOfWork: $request->input('type_of_work'),
            socialMediaLinks: self::processJsonArray($request->input('social_media_links')),
            biography: $request->input('biography'),
            userIds: self::processJsonArray($request->input('user_ids'))
        );
    }
}
