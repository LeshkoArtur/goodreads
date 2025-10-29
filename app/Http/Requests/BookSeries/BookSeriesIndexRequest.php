<?php

namespace App\Http\Requests\BookSeries;

use App\Models\BookSeries;
use Illuminate\Foundation\Http\FormRequest;

class BookSeriesIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', BookSeries::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:title,created_at,total_books'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'min_total_books' => ['nullable', 'integer', 'min:1'],
            'max_total_books' => ['nullable', 'integer', 'min:1'],
            'is_completed' => ['nullable', 'boolean'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису серії.',
                'example' => 'Фентезійна серія',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість серій на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (title, created_at, total_books).',
                'example' => 'title',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'min_total_books' => [
                'description' => 'Мінімальна кількість книг у серії для фільтрації.',
                'example' => 1,
            ],
            'max_total_books' => [
                'description' => 'Максимальна кількість книг у серії для фільтрації.',
                'example' => 10,
            ],
            'is_completed' => [
                'description' => 'Фільтр за статусом завершення серії.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
