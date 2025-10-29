<?php

namespace App\Http\Requests\Favorite;

use App\Models\Favorite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FavoriteIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Favorite::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at,updated_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'favoriteable_type' => [
                'nullable',
                'string',
                'max:255',
                Rule::in([
                    'App\\Models\\Book',
                    'App\\Models\\Post',
                    'App\\Models\\GroupPost',
                    'App\\Models\\Quote',
                    'App\\Models\\Rating',
                ]),
            ],
            'favoriteable_id' => ['nullable', 'uuid'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит.',
                'example' => '',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість улюблених на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'Фільтр за UUID користувача.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'favoriteable_type' => [
                'description' => 'Фільтр за типом об\'єкта улюбленого. Можливі значення: App\\Models\\Book, App\\Models\\Post, App\\Models\\GroupPost, App\\Models\\Quote, App\\Models\\Rating.',
                'example' => 'App\\Models\\Book',
            ],
            'favoriteable_id' => [
                'description' => 'Фільтр за UUID об\'єкта улюбленого.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
