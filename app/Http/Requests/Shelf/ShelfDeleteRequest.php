<?php

namespace App\Http\Requests\Shelf;

use Illuminate\Foundation\Http\FormRequest;

class ShelfDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $shelf = $this->route('shelf');

        return $this->user()?->can('delete', $shelf) ?? false;
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
            'shelf' => [
                'description' => 'ID полиці для видалення.',
                'example' => 'shelf-uuid123',
            ],
        ];
    }
}
