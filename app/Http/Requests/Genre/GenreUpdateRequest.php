<?php

namespace App\Http\Requests\Genre;

use Illuminate\Foundation\Http\FormRequest;

class GenreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $genre = $this->route('genre');

        return $this->user()?->can('update', $genre) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:50'],
            'parent_id' => ['nullable', 'uuid', 'exists:genres,id'],
            'description' => ['nullable', 'string'],
            'book_count' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва жанру.',
                'example' => 'Епічне фентезі',
            ],
            'parent_id' => [
                'description' => 'ID батьківського жанру.',
                'example' => 'genre-uuid123',
            ],
            'description' => [
                'description' => 'Опис жанру.',
                'example' => 'Оновлений опис жанру епічного фентезі.',
            ],
            'book_count' => [
                'description' => 'Кількість книг у жанрі.',
                'example' => 50,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'genre' => [
                'description' => 'ID жанру для оновлення.',
                'example' => 'genre-uuid123',
            ],
        ];
    }
}
