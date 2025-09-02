<?php

namespace App\Http\Requests\GroupPost;

use App\Models\GroupPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupPostIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', GroupPost::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:content,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'string', 'exists:groups,id'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'is_pinned' => ['nullable', 'boolean'],
            'category' => ['nullable', Rule::in(\App\Enums\PostCategory::values())],
            'post_status' => ['nullable', Rule::in(\App\Enums\PostStatus::values())],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для вмісту поста.',
                'example' => 'Обговорення книги',
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
                'description' => 'Поле для сортування (content, created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'group_id' => [
                'description' => 'Фільтр за ID групи.',
                'example' => 'group-uuid123',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача, який створив пост.',
                'example' => 'user-uuid123',
            ],
            'is_pinned' => [
                'description' => 'Фільтр за статусом закріплення поста.',
                'example' => true,
            ],
            'category' => [
                'description' => 'Фільтр за категорією поста.',
                'example' => 'DISCUSSION',
            ],
            'post_status' => [
                'description' => 'Фільтр за статусом поста.',
                'example' => 'PUBLISHED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
