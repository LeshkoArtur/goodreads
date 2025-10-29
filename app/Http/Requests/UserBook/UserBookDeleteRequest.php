<?php

namespace App\Http\Requests\UserBook;

use Illuminate\Foundation\Http\FormRequest;

class UserBookDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $userBook = $this->route('user_book');

        return $this->user()?->can('delete', $userBook) ?? false;
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'user_book' => [
                'description' => 'ID зв’язку між користувачем та книгою для видалення.',
                'example' => 'user-book-uuid123',
            ],
        ];
    }
}
