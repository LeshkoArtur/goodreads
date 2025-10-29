<?php

namespace App\Http\Requests\GroupPost;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use App\Models\GroupPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupPostIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', GroupPost::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at,updated_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'uuid', 'exists:groups,id'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'is_pinned' => ['nullable', 'boolean'],
            'category' => ['nullable', Rule::enum(PostCategory::class)],
            'post_status' => ['nullable', Rule::enum(PostStatus::class)],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для контенту посту.',
                'example' => 'Цікавий пост',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість постів на сторінці.',
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
            'group_id' => [
                'description' => 'Фільтр за UUID групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'user_id' => [
                'description' => 'Фільтр за UUID користувача.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'is_pinned' => [
                'description' => 'Фільтр за закріпленими постами.',
                'example' => true,
            ],
            'category' => [
                'description' => 'Фільтр за категорією посту.',
                'example' => 'general',
            ],
            'post_status' => [
                'description' => 'Фільтр за статусом посту.',
                'example' => 'published',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
