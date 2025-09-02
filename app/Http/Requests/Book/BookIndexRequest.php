<?php

namespace App\Http\Requests\Book;

use App\Enums\AgeRestriction;
use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Book::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:title,created_at,average_rating'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'series_id' => ['nullable', 'string', 'exists:book_series,id'],
            'min_page_count' => ['nullable', 'integer', 'min:1'],
            'max_page_count' => ['nullable', 'integer', 'min:1'],
            'languages' => ['nullable', 'json'],
            'is_bestseller' => ['nullable', 'boolean'],
            'min_average_rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'max_average_rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'age_restriction' => ['nullable', Rule::in(AgeRestriction::values())],
            'author_ids' => ['nullable', 'json'],
            'genre_ids' => ['nullable', 'json'],
            'publisher_ids' => ['nullable', 'json'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису книги.',
                'example' => 'Фентезійний роман',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість книг на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (title, created_at, average_rating).',
                'example' => 'title',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'series_id' => [
                'description' => 'Фільтр за ID серії книг.',
                'example' => 'series-uuid123',
            ],
            'min_page_count' => [
                'description' => 'Мінімальна кількість сторінок для фільтрації.',
                'example' => 100,
            ],
            'max_page_count' => [
                'description' => 'Максимальна кількість сторінок для фільтрації.',
                'example' => 500,
            ],
            'languages' => [
                'description' => 'Фільтр за мовами (JSON масив).',
                'example' => '["Англійська", "Іспанська"]',
            ],
            'is_bestseller' => [
                'description' => 'Фільтр за статусом бестселера.',
                'example' => true,
            ],
            'min_average_rating' => [
                'description' => 'Мінімальний середній рейтинг для фільтрації.',
                'example' => 4.0,
            ],
            'max_average_rating' => [
                'description' => 'Максимальний середній рейтинг для фільтрації.',
                'example' => 5.0,
            ],
            'age_restriction' => [
                'description' => 'Фільтр за віковими обмеженнями.',
                'example' => 'Дорослі',
            ],
            'author_ids' => [
                'description' => 'Фільтр за ID авторів (JSON масив).',
                'example' => '["author-uuid1", "author-uuid2"]',
            ],
            'genre_ids' => [
                'description' => 'Фільтр за ID жанрів (JSON масив).',
                'example' => '["genre-uuid1", "genre-uuid2"]',
            ],
            'publisher_ids' => [
                'description' => 'Фільтр за ID видавців із додатковими даними (JSON масив об’єктів).',
                'example' => '[{"id":"publisher-uuid1","published_date":"2020-01-01","isbn":"978-3-16-148410-0","circulation":1000,"format":"Hardcover","cover_type":"Glossy","translator":"John Smith","edition":1,"price":29.99,"binding":"Sewn"},{"id":"publisher-uuid2","published_date":"2021-06-15","isbn":"978-1-23-456789-0","circulation":500,"format":"Paperback","cover_type":"Matte","translator":null,"edition":2,"price":19.99,"binding":"Glued"}]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
