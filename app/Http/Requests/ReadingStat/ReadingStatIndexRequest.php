<?php

namespace App\Http\Requests\ReadingStat;

use App\Models\ReadingStat;
use Illuminate\Foundation\Http\FormRequest;

class ReadingStatIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', ReadingStat::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:year,books_read,pages_read,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'status' => ['nullable', 'string', 'in:PLANNING,READING,FINISHED'],
            'min_pages_read' => ['nullable', 'integer', 'min:0'],
            'max_pages_read' => ['nullable', 'integer', 'min:0', 'gte:min_pages_read'],
            'min_start_date' => ['nullable', 'date'],
            'max_start_date' => ['nullable', 'date', 'after_or_equal:min_start_date'],
            'min_finish_date' => ['nullable', 'date'],
            'max_finish_date' => ['nullable', 'date', 'after_or_equal:min_finish_date'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для статистики читання.',
                'example' => 'Читання 2023',
            ],
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
            'book_id' => [
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'status' => [
                'description' => 'Фільтр за статусом читання (PLANNING, READING, FINISHED).',
                'example' => 'FINISHED',
            ],
            'min_pages_read' => [
                'description' => 'Мінімальна кількість прочитаних сторінок для фільтрації.',
                'example' => 0,
            ],
            'max_pages_read' => [
                'description' => 'Максимальна кількість прочитаних сторінок для фільтрації.',
                'example' => 1000,
            ],
            'min_start_date' => [
                'description' => 'Мінімальна дата початку читання.',
                'example' => '2023-01-01',
            ],
            'max_start_date' => [
                'description' => 'Максимальна дата початку читання.',
                'example' => '2023-12-31',
            ],
            'min_finish_date' => [
                'description' => 'Мінімальна дата завершення читання.',
                'example' => '2023-01-01',
            ],
            'max_finish_date' => [
                'description' => 'Максимальна дата завершення читання.',
                'example' => '2023-12-31',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
