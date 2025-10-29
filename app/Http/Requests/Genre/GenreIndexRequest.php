<?php

namespace App\Http\Requests\Genre;

use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;

class GenreIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Genre::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at,book_count'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'parent_id' => ['nullable', 'uuid', 'exists:genres,id'],
            'min_book_count' => ['nullable', 'integer', 'min:0'],
            'max_book_count' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису жанру.',
                'example' => 'Фентезі',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість жанрів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, created_at, book_count).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'parent_id' => [
                'description' => 'Фільтр за ID батьківського жанру.',
                'example' => 'genre-uuid123',
            ],
            'min_book_count' => [
                'description' => 'Мінімальна кількість книг у жанрі для фільтрації.',
                'example' => 1,
            ],
            'max_book_count' => [
                'description' => 'Максимальна кількість книг у жанрі для фільтрації.',
                'example' => 100,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
