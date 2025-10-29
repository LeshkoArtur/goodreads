<?php

namespace App\Http\Requests\ReadingStat;

use App\Models\ReadingStat;
use Illuminate\Foundation\Http\FormRequest;

class ReadingStatIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', ReadingStat::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:year,books_read,pages_read,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'year' => ['nullable', 'integer', 'min:1900'],
            'min_books_read' => ['nullable', 'integer', 'min:0'],
            'max_books_read' => ['nullable', 'integer', 'min:0', 'gte:min_books_read'],
            'min_pages_read' => ['nullable', 'integer', 'min:0'],
            'max_pages_read' => ['nullable', 'integer', 'min:0', 'gte:min_pages_read'],
            'genres_read' => ['nullable', 'array'],
            'genres_read.*' => ['string', 'max:100'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість записів статистики на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (year, books_read, pages_read, created_at).',
                'example' => 'year',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача.',
                'example' => 'user-uuid123',
            ],
            'year' => [
                'description' => 'Фільтр за роком.',
                'example' => 2023,
            ],
            'min_books_read' => [
                'description' => 'Мінімальна кількість прочитаних книг.',
                'example' => 5,
            ],
            'max_books_read' => [
                'description' => 'Максимальна кількість прочитаних книг.',
                'example' => 50,
            ],
            'min_pages_read' => [
                'description' => 'Мінімальна кількість прочитаних сторінок.',
                'example' => 0,
            ],
            'max_pages_read' => [
                'description' => 'Максимальна кількість прочитаних сторінок.',
                'example' => 1000,
            ],
            'genres_read' => [
                'description' => 'Фільтр за прочитаними жанрами (масив).',
                'example' => '["Фантастика", "Класика"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
