<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class BookDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $book = $this->route('book');
        return $this->user()->can('delete', $book);
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
            'book' => [
                'description' => 'ID книги для видалення.',
                'example' => 'book-uuid123',
            ],
        ];
    }
}
