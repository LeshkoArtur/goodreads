<?php

namespace App\DTOs\User;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserStoreDTO
{
    use HandlesJsonArrays;

    /**
     * @param string $username Ім'я користувача
     * @param string $email Електронна пошта
     * @param string $password Пароль
     * @param string|null $emailVerifiedAt Дата верифікації email у форматі Y-m-d H:i:s
     * @param string|null $profilePicture Фото профілю
     * @param string|null $bio Біографія
     * @param bool $isPublic Чи публічний профіль
     * @param string|null $birthday Дата народження у форматі Y-m-d
     * @param string|null $location Місцезнаходження
     * @param string|null $lastLogin Останній вхід у форматі Y-m-d H:i:s
     * @param array|Collection|null $socialMediaLinks Посилання на соцмережі
     * @param Role|null $role Роль
     * @param Gender|null $gender Стать
     */
    public function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $emailVerifiedAt = null,
        public readonly ?string $profilePicture = null,
        public readonly ?string $bio = null,
        public readonly bool $isPublic = false,
        public readonly ?string $birthday = null,
        public readonly ?string $location = null,
        public readonly ?string $lastLogin = null,
        public readonly array|Collection|null $socialMediaLinks = null,
        public readonly ?Role $role = null,
        public readonly ?Gender $gender = null
    ) {
    }

    /**
     * Створити UserStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            username: $request->input('username'),
            email: $request->input('email'),
            password: $request->input('password'),
            emailVerifiedAt: $request->input('email_verified_at'),
            profilePicture: $request->input('profile_picture'),
            bio: $request->input('bio'),
            isPublic: $request->input('is_public', false),
            birthday: $request->input('birthday'),
            location: $request->input('location'),
            lastLogin: $request->input('last_login'),
            socialMediaLinks: self::processJsonArray($request->input('social_media_links')),
            role: $request->input('role') ? Role::from($request->input('role')) : null,
            gender: $request->input('gender') ? Gender::from($request->input('gender')) : null
        );
    }
}
