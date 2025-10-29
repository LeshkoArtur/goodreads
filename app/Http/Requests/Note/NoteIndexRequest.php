<?php

namespace App\Http\Requests\Note;

use App\Models\Note;
use Illuminate\Foundation\Http\FormRequest;

class NoteIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Note::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:text,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'book_id' => ['nullable', 'uuid', 'exists:books,id'],
            'contains_spoilers' => ['nullable', 'boolean'],
            'is_private' => ['nullable', 'boolean'],
            'min_page_number' => ['nullable', 'integer', 'min:1'],
            'max_page_number' => ['nullable', 'integer', 'min:1', 'gte:min_page_number'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для тексту нотатки.',
                'example' => 'Цікава цитата',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість нотаток на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (text, created_at).',
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
            'contains_spoilers' => [
                'description' => 'Фільтр за наявністю спойлерів.',
                'example' => true,
            ],
            'is_private' => [
                'description' => 'Фільтр за приватністю нотатки.',
                'example' => false,
            ],
            'min_page_number' => [
                'description' => 'Мінімальний номер сторінки для фільтрації.',
                'example' => 1,
            ],
            'max_page_number' => [
                'description' => 'Максимальний номер сторінки для фільтрації.',
                'example' => 100,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
