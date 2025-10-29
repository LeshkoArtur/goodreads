<?php

namespace App\Http\Requests\User;

use App\Enums\Gender;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', User::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:username,created_at,last_login'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'location' => ['nullable', 'string', 'max:255'],
            'min_birthday' => ['nullable', 'date'],
            'max_birthday' => ['nullable', 'date'],
            'role' => ['nullable', Rule::enum(Role::class)],
            'gender' => ['nullable', Rule::enum(Gender::class)],
            'is_public' => ['nullable', 'boolean'],
            'author_ids' => ['nullable', 'array'],
            'author_ids.*' => ['uuid', 'exists:authors,id'],
            'group_ids' => ['nullable', 'array'],
            'group_ids.*' => ['uuid', 'exists:groups,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для імені користувача або біографії.',
                'example' => 'john',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість користувачів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (username, created_at, last_login).',
                'example' => 'username',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'location' => [
                'description' => 'Фільтр за місцезнаходженням.',
                'example' => 'Київ, Україна',
            ],
            'min_birthday' => [
                'description' => 'Мінімальна дата народження для фільтрації.',
                'example' => '1980-01-01',
            ],
            'max_birthday' => [
                'description' => 'Максимальна дата народження для фільтрації.',
                'example' => '2000-01-01',
            ],
            'role' => [
                'description' => 'Фільтр за роллю користувача (user, author, librarian, admin).',
                'example' => 'user',
            ],
            'gender' => [
                'description' => 'Фільтр за статтю (male, female, other).',
                'example' => 'male',
            ],
            'is_public' => [
                'description' => 'Фільтр за публічністю профілю.',
                'example' => true,
            ],
            'author_ids' => [
                'description' => 'Фільтр за UUID авторів (масив).',
                'example' => '["9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a"]',
            ],
            'group_ids' => [
                'description' => 'Фільтр за UUID груп (масив).',
                'example' => '["8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
