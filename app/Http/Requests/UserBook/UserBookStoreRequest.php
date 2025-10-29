<?php

namespace App\Http\Requests\UserBook;

use App\Enums\ReadingFormat;
use App\Models\UserBook;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserBookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', UserBook::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'book_id' => ['required', 'uuid', 'exists:books,id'],
            'shelf_id' => ['nullable', 'uuid', 'exists:shelves,id'],
            'start_date' => ['nullable', 'date'],
            'read_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'progress_pages' => ['nullable', 'integer', 'min:0'],
            'is_private' => ['nullable', 'boolean'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'notes' => ['nullable', 'string'],
            'reading_format' => ['nullable', Rule::enum(ReadingFormat::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, якому належить книга.',
                'example' => 'user-uuid123',
            ],
            'book_id' => [
                'description' => 'ID книги.',
                'example' => 'book-uuid123',
            ],
            'shelf_id' => [
                'description' => 'ID полиці, до якої додано книгу.',
                'example' => 'shelf-uuid123',
            ],
            'start_date' => [
                'description' => 'Дата початку читання у форматі Y-m-d.',
                'example' => '2025-01-01',
            ],
            'read_date' => [
                'description' => 'Дата завершення читання у форматі Y-m-d.',
                'example' => '2025-06-01',
            ],
            'progress_pages' => [
                'description' => 'Прогрес читання у сторінках.',
                'example' => 150,
            ],
            'is_private' => [
                'description' => 'Чи є запис приватним.',
                'example' => false,
            ],
            'rating' => [
                'description' => 'Оцінка книги (від 1 до 10).',
                'example' => 8,
            ],
            'notes' => [
                'description' => 'Нотатки про книгу.',
                'example' => 'Цікава книга про пригоди.',
            ],
            'reading_format' => [
                'description' => 'Формат читання (наприклад, PAPERBACK, EBOOK, AUDIOBOOK).',
                'example' => 'EBOOK',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
