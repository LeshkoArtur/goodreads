<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email_verified_at' => ['nullable', 'date'],
            'profile_picture' => ['nullable', 'url', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'is_public' => ['boolean'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'location' => ['nullable', 'string', 'max:255'],
            'last_login' => ['nullable', 'date'],
            'social_media_links' => ['nullable', 'array'],
            'social_media_links.*' => ['string', 'url', 'max:255'],
            'role' => ['nullable', Rule::in(\App\Enums\Role::values())],
            'gender' => ['nullable', Rule::in(\App\Enums\Gender::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'username' => [
                'description' => 'Ім’я користувача.',
                'example' => 'john_doe',
            ],
            'email' => [
                'description' => 'Електронна пошта користувача.',
                'example' => 'john.doe@example.com',
            ],
            'password' => [
                'description' => 'Пароль користувача (мінімум 8 символів).',
                'example' => 'password123',
            ],
            'email_verified_at' => [
                'description' => 'Дата верифікації email у форматі Y-m-d H:i:s.',
                'example' => '2025-08-13 20:50:00',
            ],
            'profile_picture' => [
                'description' => 'URL фотографії профілю.',
                'example' => 'https://example.com/profile.jpg',
            ],
            'bio' => [
                'description' => 'Біографія користувача.',
                'example' => 'Люблю читати фантастику та подорожувати.',
            ],
            'is_public' => [
                'description' => 'Чи є профіль публічним.',
                'example' => true,
            ],
            'birthday' => [
                'description' => 'Дата народження у форматі Y-m-d.',
                'example' => '1990-05-15',
            ],
            'location' => [
                'description' => 'Місцезнаходження користувача.',
                'example' => 'Київ',
            ],
            'last_login' => [
                'description' => 'Останній вхід у форматі Y-m-d H:i:s.',
                'example' => '2025-08-13 20:50:00',
            ],
            'social_media_links' => [
                'description' => 'Посилання на соціальні мережі.',
                'example' => ['https://twitter.com/john_doe', 'https://facebook.com/john_doe'],
            ],
            'role' => [
                'description' => 'Роль користувача (наприклад, USER, ADMIN).',
                'example' => 'USER',
            ],
            'gender' => [
                'description' => 'Стать користувача.',
                'example' => 'MALE',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
