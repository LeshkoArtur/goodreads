<?php

namespace App\Http\Requests\Quote;

use App\Models\Quote;
use Illuminate\Foundation\Http\FormRequest;

class QuoteStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Quote::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'book_id' => ['required', 'uuid', 'exists:books,id'],
            'text' => ['required', 'string'],
            'page_number' => ['nullable', 'integer', 'min:1'],
            'contains_spoilers' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який додає цитату.',
                'example' => 'user-uuid123',
            ],
            'book_id' => [
                'description' => 'ID книги, до якої відноситься цитата.',
                'example' => 'book-uuid123',
            ],
            'text' => [
                'description' => 'Текст цитати.',
                'example' => 'Це найкраща цитата з книги!',
            ],
            'page_number' => [
                'description' => 'Номер сторінки, де знаходиться цитата.',
                'example' => 42,
            ],
            'contains_spoilers' => [
                'description' => 'Чи містить цитата спойлери.',
                'example' => false,
            ],
            'is_public' => [
                'description' => 'Чи є цитата публічною.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
