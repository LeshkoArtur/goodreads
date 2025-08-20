<?php

namespace App\Http\Requests\Author;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Author::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at,birth_date'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'min_birth_date' => ['nullable', 'date'],
            'max_birth_date' => ['nullable', 'date'],
            'min_death_date' => ['nullable', 'date'],
            'max_death_date' => ['nullable', 'date'],
            'type_of_work' => ['nullable', Rule::in(\App\Enums\TypeOfWork::values())],
            'social_media_links' => ['nullable', 'json'],
            'user_ids' => ['nullable', 'json'],
            'book_ids' => ['nullable', 'json'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для імені або біографії автора.',
                'example' => 'Джейн Доу',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість авторів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, created_at, birth_date).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'nationality' => [
                'description' => 'Фільтр за національністю.',
                'example' => 'Американець',
            ],
            'min_birth_date' => [
                'description' => 'Мінімальна дата народження для фільтрації.',
                'example' => '1900-01-01',
            ],
            'max_birth_date' => [
                'description' => 'Максимальна дата народження для фільтрації.',
                'example' => '2000-01-01',
            ],
            'min_death_date' => [
                'description' => 'Мінімальна дата смерті для фільтрації.',
                'example' => '1950-01-01',
            ],
            'max_death_date' => [
                'description' => 'Максимальна дата смерті для фільтрації.',
                'example' => '2020-01-01',
            ],
            'type_of_work' => [
                'description' => 'Фільтр за типом роботи.',
                'example' => 'Романіст',
            ],
            'social_media_links' => [
                'description' => 'Фільтр за посиланнями на соціальні мережі (JSON масив).',
                'example' => '["https://twitter.com/author", "https://facebook.com/author"]',
            ],
            'user_ids' => [
                'description' => 'Фільтр за ID користувачів (JSON масив).',
                'example' => '["user-uuid1", "user-uuid2"]',
            ],
            'book_ids' => [
                'description' => 'Фільтр за ID книг (JSON масив).',
                'example' => '["book-uuid1", "book-uuid2"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
