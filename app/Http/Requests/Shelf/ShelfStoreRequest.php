<?php

namespace App\Http\Requests\Shelf;

use App\Models\Shelf;
use Illuminate\Foundation\Http\FormRequest;

class ShelfStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Shelf::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255', 'unique:shelves,name,NULL,id,user_id,' . $this->input('user_id')],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, якому належить полиця.',
                'example' => 'user-uuid123',
            ],
            'name' => [
                'description' => 'Назва полиці.',
                'example' => 'Моя бібліотека',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
