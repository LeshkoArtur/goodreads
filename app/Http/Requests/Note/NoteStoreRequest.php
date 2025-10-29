<?php

namespace App\Http\Requests\Note;

use App\Models\Note;
use Illuminate\Foundation\Http\FormRequest;

class NoteStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Note::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'book_id' => ['required', 'uuid', 'exists:books,id'],
            'text' => ['required', 'string'],
            'page_number' => ['nullable', 'integer', 'min:1'],
            'contains_spoilers' => ['nullable', 'boolean'],
            'is_private' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який створює нотатку.',
                'example' => 'user-uuid123',
            ],
            'book_id' => [
                'description' => 'ID книги, до якої відноситься нотатка.',
                'example' => 'book-uuid123',
            ],
            'text' => [
                'description' => 'Текст нотатки.',
                'example' => 'Цікава цитата зі сторінки 42.',
            ],
            'page_number' => [
                'description' => 'Номер сторінки, до якої відноситься нотатка.',
                'example' => 42,
            ],
            'contains_spoilers' => [
                'description' => 'Чи містить нотатка спойлери.',
                'example' => false,
            ],
            'is_private' => [
                'description' => 'Чи є нотатка приватною.',
                'example' => false,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
