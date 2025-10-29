<?php

namespace App\Http\Requests\Author;

use App\Enums\TypeOfWork;
use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Author::class) ?? true;
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
            'type_of_work' => ['nullable', Rule::enum(TypeOfWork::class)],
            'user_ids' => ['nullable', 'array'],
            'user_ids.*' => ['uuid', 'exists:users,id'],
            'book_ids' => ['nullable', 'array'],
            'book_ids.*' => ['uuid', 'exists:books,id'],
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
                'description' => 'Фільтр за типом роботи (novelist, poet, playwright, тощо).',
                'example' => 'novelist',
            ],
            'user_ids' => [
                'description' => 'Фільтр за UUID користувачів (масив).',
                'example' => '["9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a"]',
            ],
            'book_ids' => [
                'description' => 'Фільтр за UUID книг (масив).',
                'example' => '["8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b"]',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
