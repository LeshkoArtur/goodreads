<?php

namespace App\Http\Requests\Shelf;

use App\Models\Shelf;
use Illuminate\Foundation\Http\FormRequest;

class ShelfIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Shelf::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви полиці.',
                'example' => 'Моя бібліотека',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість полиць на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, created_at).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача, якому належить полиця.',
                'example' => 'user-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
