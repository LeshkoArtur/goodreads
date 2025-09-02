<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->route('user');
        return $this->user()->can('update', $user);
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name' => ['nullable', 'string', 'max:255', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', Rule::in(\App\Enums\Role::values())],
            'gender' => ['nullable', Rule::in(\App\Enums\Gender::values())],
            'is_public' => ['nullable', 'boolean'],
            'location' => ['nullable', 'string', 'max:255'],
            'social_media_links' => ['nullable', 'array'],
            'social_media_links.*' => ['string', 'url', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Ім’я користувача.',
                'example' => 'john_doe_updated',
            ],
            'email' => [
                'description' => 'Електронна пошта користувача.',
                'example' => 'john.doe.updated@example.com',
            ],
            'password' => [
                'description' => 'Новий пароль користувача (мінімум 8 символів).',
                'example' => 'newpassword123',
            ],
            'role' => [
                'description' => 'Роль користувача (наприклад, USER, ADMIN).',
                'example' => 'ADMIN',
            ],
            'gender' => [
                'description' => 'Стать користувача.',
                'example' => 'FEMALE',
            ],
            'is_public' => [
                'description' => 'Чи є профіль публічним.',
                'example' => false,
            ],
            'location' => [
                'description' => 'Місцезнаходження користувача.',
                'example' => 'Львів',
            ],
            'social_media_links' => [
                'description' => 'Посилання на соціальні мережі.',
                'example' => ['https://twitter.com/john_doe_updated', 'https://facebook.com/john_doe_updated'],
            ],
            'birthday' => [
                'description' => 'Дата народження у форматі Y-m-d.',
                'example' => '1990-05-15',
            ],
            'bio' => [
                'description' => 'Біографія користувача.',
                'example' => 'Оновлена біографія: люблю читати та подорожувати.',
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
