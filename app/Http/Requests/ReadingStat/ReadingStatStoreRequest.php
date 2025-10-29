<?php

namespace App\Http\Requests\ReadingStat;

use App\Models\ReadingStat;
use Illuminate\Foundation\Http\FormRequest;

class ReadingStatStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', ReadingStat::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'string',
                'exists:users,id',
                'unique:reading_stats,user_id,NULL,id,year,'.$this->input('year')
            ],
            'year' => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'books_read' => ['required', 'integer', 'min:0'],
            'pages_read' => ['required', 'integer', 'min:0'],
            'genres_read' => ['nullable', 'array'],
            'genres_read.*' => ['string', 'max:100'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, для якого створюється статистика.',
                'example' => 'user-uuid123',
            ],
            'year' => [
                'description' => 'Рік, для якого ведеться статистика.',
                'example' => 2023,
            ],
            'books_read' => [
                'description' => 'Кількість прочитаних книг.',
                'example' => 10,
            ],
            'pages_read' => [
                'description' => 'Кількість прочитаних сторінок.',
                'example' => 2500,
            ],
            'genres_read' => [
                'description' => 'Масив прочитаних жанрів.',
                'example' => ['Фантастика', 'Класика'],
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
