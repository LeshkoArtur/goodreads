<?php

namespace App\Http\Requests\Shelf;

use Illuminate\Foundation\Http\FormRequest;

class ShelfUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $shelf = $this->route('shelf');

        return $this->user()?->can('update', $shelf) ?? false;
    }

    public function rules(): array
    {
        $shelf = $this->route('shelf');

        return [
            'name' => ['nullable', 'string', 'max:50', 'unique:shelves,name,'.$shelf->id.',id,user_id,'.$shelf->user_id],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва полиці.',
                'example' => 'Оновлена бібліотека',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'shelf' => [
                'description' => 'ID полиці для оновлення.',
                'example' => 'shelf-uuid123',
            ],
        ];
    }
}
