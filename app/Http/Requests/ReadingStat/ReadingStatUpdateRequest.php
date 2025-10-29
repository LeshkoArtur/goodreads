<?php

namespace App\Http\Requests\ReadingStat;

use Illuminate\Foundation\Http\FormRequest;

class ReadingStatUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $readingStat = $this->route('reading_stat');

        return $this->user()?->can('update', $readingStat) ?? false;
    }

    public function rules(): array
    {
        return [
            'books_read' => ['nullable', 'integer', 'min:0'],
            'pages_read' => ['nullable', 'integer', 'min:0'],
            'genres_read' => ['nullable', 'array'],
            'genres_read.*' => ['string', 'max:100'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
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
        return [
            'reading_stat' => [
                'description' => 'ID статистики читання для оновлення.',
                'example' => 'reading-stat-uuid123',
            ],
        ];
    }
}
