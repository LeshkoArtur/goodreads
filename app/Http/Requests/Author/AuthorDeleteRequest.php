<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class AuthorDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $author = $this->route('author');

        return $this->user()?->can('delete', $author) ?? false;
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
            'author' => [
                'description' => 'ID автора для видалення.',
                'example' => 'author-uuid123',
            ],
        ];
    }
}
