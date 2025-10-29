<?php

namespace App\Http\Requests\UserBook;

use App\Models\UserBook;
use Illuminate\Foundation\Http\FormRequest;

class UserBookIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', UserBook::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at,updated_at,start_date,read_date,progress_pages,rating'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'book_id' => ['nullable', 'uuid', 'exists:books,id'],
            'shelf_id' => ['nullable', 'uuid', 'exists:shelves,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для нотаток або назви книги.',
                'example' => 'Читання 2025',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість записів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at, updated_at, start_date, read_date, progress_pages, rating).',
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
            'book_id' => [
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'shelf_id' => [
                'description' => 'Фільтр за ID полиці.',
                'example' => 'shelf-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
