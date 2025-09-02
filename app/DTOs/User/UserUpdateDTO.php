<?php

namespace App\DTOs\User;

use App\DTOs\Traits\HandlesArrayInput;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних користувача.
 */
class UserUpdateDTO
{
    use HandlesArrayInput;

    /**
     * Створює новий екземпляр UserUpdateDTO.
     *
     * @param string|null $name Ім’я користувача
     * @param string|null $email Email користувача
     * @param string|null $password Пароль користувача
     * @param string|null $role Роль користувача
     * @param string|null $gender Стать користувача
     * @param bool|null $isPublic Видимість профілю
     * @param string|null $location Місце розташування
     * @param array|null $socialMediaLinks Соціальні мережі
     * @param string|null $birthday Дата народження
     * @param string|null $bio Біографія користувача
     */
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
        public readonly ?string $role = null,
        public readonly ?string $gender = null,
        public readonly ?bool $isPublic = null,
        public readonly ?string $location = null,
        public readonly ?array $socialMediaLinks = null,
        public readonly ?string $birthday = null,
        public readonly ?string $bio = null,
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
            email: $request->input('email'),
            password: $request->input('password'),
            role: $request->input('role'),
            gender: $request->input('gender'),
            isPublic: $request->has('is_public') ? $request->boolean('is_public') : null,
            location: $request->input('location'),
            socialMediaLinks: self::processArrayInput($request, 'social_media_links'),
            birthday: $request->input('birthday'),
            bio: $request->input('bio'),
        );
    }
}
