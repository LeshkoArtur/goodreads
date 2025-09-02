<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Comment::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'commentable_type' => ['nullable', 'string', 'in:App\Models\Book,App\Models\Post'],
            'commentable_id' => ['nullable', 'string'],
            'is_root' => ['nullable', 'boolean'],
            'parent_id' => ['nullable', 'string', 'exists:comments,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для тексту коментаря.',
                'example' => 'Цікава книга',
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
                'description' => 'Фільтр за ID користувача.',
                'example' => 'user-uuid123',
            ],
            'commentable_type' => [
                'description' => 'Фільтр за типом коментованого об’єкта (напр., App\Models\Book).',
                'example' => 'App\Models\Book',
            ],
            'commentable_id' => [
                'description' => 'Фільтр за ID коментованого об’єкта.',
                'example' => 'book-uuid123',
            ],
            'is_root' => [
                'description' => 'Фільтр за статусом кореня (коментарі без батьківського коментаря).',
                'example' => true,
            ],
            'parent_id' => [
                'description' => 'Фільтр за ID батьківського коментаря.',
                'example' => 'comment-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
