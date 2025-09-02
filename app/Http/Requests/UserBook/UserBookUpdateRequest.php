<?php

namespace App\Http\Requests\UserBook;

use App\Models\UserBook;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserBookUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $userBook = $this->route('user_book');
        return $this->user()->can('update', $userBook);
    }

    public function rules(): array
    {
        return [
            'shelf_id' => ['nullable', 'string', 'exists:shelves,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'shelf_id' => [
                'description' => 'ID полиці, до якої додано книгу.',
                'example' => 'shelf-uuid123',
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
