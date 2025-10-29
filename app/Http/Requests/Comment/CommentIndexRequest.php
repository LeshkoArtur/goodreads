<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Comment::class) ?? true;
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
            'commentable_type' => [
                'nullable',
                'string',
                'max:255',
                Rule::in([
                    'App\\Models\\Post',
                    'App\\Models\\GroupPost',
                    'App\\Models\\Quote',
                    'App\\Models\\Rating',
                ]),
            ],
            'commentable_id' => ['nullable', 'uuid'],
            'parent_id' => ['nullable', 'uuid', 'exists:comments,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для контенту коментаря.',
                'example' => 'Чудова книга',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість коментарів на сторінці.',
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
            'commentable_type' => [
                'description' => 'Фільтр за типом об\'єкта коментаря. Можливі значення: App\\Models\\Post, App\\Models\\GroupPost, App\\Models\\Quote, App\\Models\\Rating.',
                'example' => 'App\\Models\\Post',
            ],
            'commentable_id' => [
                'description' => 'Фільтр за UUID об\'єкта коментаря.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'parent_id' => [
                'description' => 'Фільтр за UUID батьківського коментаря.',
                'example' => '7b5c6d1a-0a8b-2c3d-7e1b-0a1b2c3d4e5f',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
