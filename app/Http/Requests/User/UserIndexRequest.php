<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', User::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:username,email,created_at,last_login'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'role' => ['nullable', Rule::in(\App\Enums\Role::values())],
            'gender' => ['nullable', Rule::in(\App\Enums\Gender::values())],
            'is_public' => ['nullable', 'boolean'],
            'location' => ['nullable', 'string', 'max:255'],
            'social_media_links' => ['nullable', 'array'],
            'social_media_links.*' => ['string', 'url', 'max:255'],
            'min_birthday' => ['nullable', 'date'],
            'max_birthday' => ['nullable', 'date', 'after_or_equal:min_birthday'],
            'min_last_login' => ['nullable', 'date'],
            'max_last_login' => ['nullable', 'date', 'after_or_equal:min_last_login'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для імені користувача, email або біографії.',
                'example' => 'John',
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
                'description' => 'Поле для сортування (username, email, created_at, last_login).',
                'example' => 'username',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'role' => [
                'description' => 'Фільтр за роллю користувача (наприклад, USER, ADMIN).',
                'example' => 'USER',
            ],
            'gender' => [
                'description' => 'Фільтр за статтю користувача.',
                'example' => 'MALE',
            ],
            'is_public' => [
                'description' => 'Фільтр за видимістю профілю.',
                'example' => true,
            ],
            'location' => [
                'description' => 'Фільтр за місцем розташування.',
                'example' => 'Київ',
            ],
            'social_media_links' => [
                'description' => 'Фільтр за посиланнями на соціальні мережі.',
                'example' => ['https://twitter.com/example', 'https://facebook.com/example'],
            ],
            'min_birthday' => [
                'description' => 'Мінімальна дата народження для фільтрації.',
                'example' => '1990-01-01',
            ],
            'max_birthday' => [
                'description' => 'Максимальна дата народження для фільтрації.',
                'example' => '2000-12-31',
            ],
            'min_last_login' => [
                'description' => 'Мінімальний час останнього входу для фільтрації.',
                'example' => '2025-01-01 00:00:00',
            ],
            'max_last_login' => [
                'description' => 'Максимальний час останнього входу для фільтрації.',
                'example' => '2025-08-13 20:50:00',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
