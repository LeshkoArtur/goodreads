<?php

namespace App\Http\Requests\Rating;

use App\Models\Rating;
use Illuminate\Foundation\Http\FormRequest;

class RatingStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Rating::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'uuid', 'exists:users,id'],
            'book_id' => ['required', 'uuid', 'exists:books,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який залишає рейтинг.',
                'example' => 'user-uuid123',
            ],
            'book_id' => [
                'description' => 'ID книги, для якої залишається рейтинг.',
                'example' => 'book-uuid123',
            ],
            'rating' => [
                'description' => 'Оцінка книги (від 1 до 5).',
                'example' => 5,
            ],
            'review' => [
                'description' => 'Відгук до рейтингу.',
                'example' => 'Чудова книга, рекомендую!',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
