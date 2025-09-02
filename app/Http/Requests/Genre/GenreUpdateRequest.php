<?php

namespace App\Http\Requests\Genre;

use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;

class GenreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $genre = $this->route('genre');
        return $this->user()->can('update', $genre);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'string', 'exists:genres,id'],
            'description' => ['nullable', 'string'],
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
