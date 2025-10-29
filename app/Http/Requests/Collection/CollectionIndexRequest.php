<?php

namespace App\Http\Requests\Collection;

use App\Models\Collection;
use Illuminate\Foundation\Http\FormRequest;

class CollectionIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Collection::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:title,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'is_public' => ['nullable', 'boolean'],
            'book_ids' => ['nullable', 'array'],
            'book_ids.*' => ['uuid', 'exists:books,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису колекції.',
                'example' => 'Мої улюблені книги',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість колекцій на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (title, created_at).',
                'example' => 'title',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача.',
                'example' => 'user-uuid123',
            ],
            'is_public' => [
                'description' => 'Фільтр за видимістю колекції.',
                'example' => true,
            ],
            'book_ids' => [
                'description' => 'Фільтр за ID книг у колекції (JSON масив).',
                'example' => '["book-uuid123", "book-uuid456"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
