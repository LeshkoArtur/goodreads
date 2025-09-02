<?php

namespace App\Http\Requests\UserBook;

use App\Models\UserBook;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserBookStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', UserBook::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'book_id' => ['required', 'string', 'exists:books,id'],
            'shelf_id' => ['nullable', 'string', 'exists:shelves,id'],
            'start_date' => ['nullable', 'date'],
            'read_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'progress_pages' => ['nullable', 'integer', 'min:0'],
            'is_private' => ['boolean'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:10'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'reading_format' => ['nullable', Rule::in(\App\Enums\ReadingFormat::values())],
            // Ensure unique combination of user_id and book_id
            'user_id' => ['unique:user_books,user_id,NULL,id,book_id,' . $this->input('book_id')],
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
