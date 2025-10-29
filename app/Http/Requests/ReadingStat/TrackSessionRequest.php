<?php

namespace App\Http\Requests\ReadingStat;

use Illuminate\Foundation\Http\FormRequest;

class TrackSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pages_read' => ['required', 'integer', 'min:1'],
            'genres_read' => ['nullable', 'array'],
            'genres_read.*' => ['string', 'max:100'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'pages_read' => [
                'description' => 'Кількість прочитаних сторінок у сесії.',
                'example' => 25,
            ],
            'genres_read' => [
                'description' => 'Масив жанрів прочитаних книг.',
                'example' => ['Фантастика', 'Класика'],
            ],
        ];
    }
}
