<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Post::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:title,content,published_at,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'author_id' => ['nullable', 'string', 'exists:authors,id'],
            'type' => ['nullable', Rule::in(\App\Enums\PostType::values())],
            'status' => ['nullable', Rule::in(\App\Enums\PostStatus::values())],
            'min_published_at' => ['nullable', 'date'],
            'max_published_at' => ['nullable', 'date', 'after_or_equal:min_published_at'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['string', 'exists:tags,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для заголовка або вмісту поста.',
                'example' => 'Огляд книги',
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
                'description' => 'Поле для сортування (title, content, published_at, created_at).',
                'example' => 'published_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача, який створив пост.',
                'example' => 'user-uuid123',
            ],
            'book_id' => [
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'author_id' => [
                'description' => 'Фільтр за ID автора.',
                'example' => 'author-uuid123',
            ],
            'type' => [
                'description' => 'Фільтр за типом поста.',
                'example' => 'ARTICLE',
            ],
            'status' => [
                'description' => 'Фільтр за статусом поста.',
                'example' => 'PUBLISHED',
            ],
            'min_published_at' => [
                'description' => 'Мінімальна дата публікації.',
                'example' => '2023-01-01 00:00:00',
            ],
            'max_published_at' => [
                'description' => 'Максимальна дата публікації.',
                'example' => '2023-12-31 23:59:59',
            ],
            'tag_ids' => [
                'description' => 'Фільтр за масивом ID тегів.',
                'example' => ['tag-uuid123', 'tag-uuid456'],
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
