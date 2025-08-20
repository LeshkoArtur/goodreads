<?php

namespace App\Http\Requests\Shelf;

use App\Models\Shelf;
use Illuminate\Foundation\Http\FormRequest;

class ShelfUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $shelf = $this->route('shelf');
        return $this->user()->can('update', $shelf);
    }

    public function rules(): array
    {
        $shelf = $this->route('shelf');
        return [
            'name' => ['nullable', 'string', 'max:255', 'unique:shelves,name,' . $shelf->id . ',id,user_id,' . $shelf->user_id],
            'type' => ['nullable', 'string', 'in:READING,PLANNED,FINISHED'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва полиці.',
                'example' => 'Оновлена бібліотека',
            ],
            'type' => [
                'description' => 'Тип полиці (READING, PLANNED, FINISHED).',
                'example' => 'FINISHED',
            ],
            'is_public' => [
                'description' => 'Видимість полиці.',
                'example' => true,
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
