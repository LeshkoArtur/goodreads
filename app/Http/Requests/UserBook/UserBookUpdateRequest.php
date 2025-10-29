<?php

namespace App\Http\Requests\UserBook;

use App\Enums\ReadingFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserBookUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $userBook = $this->route('user_book');

        return $this->user()?->can('update', $userBook) ?? false;
    }

    public function rules(): array
    {
        return [
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
            'shelf_id' => [
                'description' => 'ID полиці, до якої додано книгу.',
                'example' => 'shelf-uuid123',
            ],
            'start_date' => [
                'description' => 'Дата початку читання.',
                'example' => '2025-01-01',
            ],
            'read_date' => [
                'description' => 'Дата завершення читання.',
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
                'description' => 'Оцінка книги (від 1 до 5).',
                'example' => 5,
            ],
            'notes' => [
                'description' => 'Нотатки про книгу.',
                'example' => 'Оновлені нотатки.',
            ],
            'reading_format' => [
                'description' => 'Формат читання.',
                'example' => 'EBOOK',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'user_book' => [
                'description' => 'ID зв’язку між користувачем та книгою для оновлення.',
                'example' => 'user-book-uuid123',
            ],
        ];
    }
}
