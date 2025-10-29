<?php

namespace App\Http\Requests\User;

use App\Enums\Gender;
use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->route('user');

        return $this->user()?->can('update', $user) ?? false;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'username' => ['nullable', 'string', 'max:50', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8'],
            'profile_picture' => ['nullable', 'url', 'max:2048'],
            'bio' => ['nullable', 'string'],
            'is_public' => ['nullable', 'boolean'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'location' => ['nullable', 'string', 'max:100'],
            'social_media_links' => ['nullable', 'array'],
            'social_media_links.*' => ['url', 'max:255'],
            'role' => ['nullable', Rule::enum(Role::class)],
            'gender' => ['nullable', Rule::enum(Gender::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'username' => [
                'description' => 'Унікальне ім\'я користувача.',
                'example' => 'john_doe',
            ],
            'email' => [
                'description' => 'Email користувача.',
                'example' => 'john.doe@example.com',
            ],
            'password' => [
                'description' => 'Пароль користувача (мінімум 8 символів).',
                'example' => 'password123',
            ],
            'profile_picture' => [
                'description' => 'URL фото профілю користувача.',
                'example' => 'https://example.com/profile.jpg',
            ],
            'bio' => [
                'description' => 'Біографія користувача.',
                'example' => 'Любитель читання...',
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
                'example' => 'Київ, Україна',
            ],
            'social_media_links' => [
                'description' => 'Посилання на соціальні мережі (масив URL).',
                'example' => '["https://twitter.com/user", "https://facebook.com/user"]',
            ],
            'role' => [
                'description' => 'Роль користувача (user, author, librarian, admin).',
                'example' => 'user',
            ],
            'gender' => [
                'description' => 'Стать користувача (male, female, other).',
                'example' => 'male',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'user' => [
                'description' => 'ID користувача для оновлення.',
                'example' => 'user-uuid123',
            ],
        ];
    }
}
