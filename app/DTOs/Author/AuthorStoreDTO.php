<?php

namespace App\DTOs\Author;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\TypeOfWork;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AuthorStoreDTO
{
    use HandlesJsonArrays;

    /**
     * @param string $name Ім'я автора
     * @param string|null $bio Біографія
     * @param string|null $birthDate Дата народження у форматі Y-m-d
     * @param string|null $birthPlace Місце народження
     * @param string|null $nationality Національність
     * @param string|null $website Вебсайт
     * @param string|null $profilePicture Фото профілю
     * @param string|null $deathDate Дата смерті у форматі Y-m-d
     * @param array|null $userIds Масив ID користувачів
     * @param array|Collection|null $socialMediaLinks Посилання на соцмережі
     * @param array|Collection|null $mediaImages Фото
     * @param array|Collection|null $mediaVideos Відео
     * @param array|Collection|null $funFacts Цікаві факти
     * @param TypeOfWork|null $typeOfWork Тип робіт
     */
    public function __construct(
        public readonly string $name,
        public readonly ?string $bio = null,
        public readonly ?string $birthDate = null,
        public readonly ?string $birthPlace = null,
        public readonly ?string $nationality = null,
        public readonly ?string $website = null,
        public readonly ?string $profilePicture = null,
        public readonly ?string $deathDate = null,
        public readonly ?array $userIds = null,
        public readonly array|Collection|null $socialMediaLinks = null,
        public readonly array|Collection|null $mediaImages = null,
        public readonly array|Collection|null $mediaVideos = null,
        public readonly array|Collection|null $funFacts = null,
        public readonly ?TypeOfWork $typeOfWork = null
    ) {}

    /**
     * Створити AuthorStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            name: $request->input('name'),
            bio: $request->input('bio'),
            birthDate: $request->input('birth_date'),
            birthPlace: $request->input('birth_place'),
            nationality: $request->input('nationality'),
            website: $request->input('website'),
            profilePicture: $request->input('profile_picture'),
            deathDate: $request->input('death_date'),
            userIds: self::processJsonArray($request->input('user_ids')),
            socialMediaLinks: self::processJsonArray($request->input('social_media_links')),
            mediaImages: self::processJsonArray($request->input('media_images')),
            mediaVideos: self::processJsonArray($request->input('media_videos')),
            funFacts: self::processJsonArray($request->input('fun_facts')),
            typeOfWork: $request->input('type_of_work')
                ? TypeOfWork::from($request->input('type_of_work'))
                : null
        );
    }
}
