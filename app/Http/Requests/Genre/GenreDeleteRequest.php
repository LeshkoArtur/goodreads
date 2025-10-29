<?php

namespace App\Http\Requests\Genre;

use Illuminate\Foundation\Http\FormRequest;

class GenreDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $genre = $this->route('genre');

        return $this->user()?->can('delete', $genre) ?? false;
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
            'genre' => [
                'description' => 'ID жанру для видалення.',
                'example' => 'genre-uuid123',
            ],
        ];
    }
}
