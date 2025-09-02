<?php

namespace App\Http\Requests\Genre;

use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;

class GenreStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Genre::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'string', 'exists:genres,id'],
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
                'example' => 'Жанр, що включає епічні пригоди у фантастичних світах.',
            ],
            'book_count' => [
                'description' => 'Кількість книг у жанрі.',
                'example' => 50,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
