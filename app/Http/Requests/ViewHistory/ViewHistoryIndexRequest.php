<?php

namespace App\Http\Requests\ViewHistory;

use Illuminate\Foundation\Http\FormRequest;

class ViewHistoryIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', \App\Models\ViewHistory::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'viewable_type' => ['nullable', 'string'],
            'viewable_id' => ['nullable', 'string'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'page' => [
                'description' => 'Номер сторінки пагінації',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість елементів на сторінці',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'ID користувача',
                'example' => 'uuid-of-user',
            ],
            'viewable_type' => [
                'description' => 'Тип переглянутого об’єкта. Можливі значення: залежить від вашої моделі (наприклад, App\\Models\\Post, App\\Models\\Book, тощо)',
                'example' => 'App\\Models\\Post',
            ],
            'viewable_id' => [
                'description' => 'ID переглянутого об’єкта',
                'example' => 'uuid-of-viewable',
            ],
            'min_viewed_at' => [
                'description' => 'Мінімальна дата перегляду',
                'example' => '2025-01-01 00:00:00',
            ],
            'max_viewed_at' => [
                'description' => 'Максимальна дата перегляду',
                'example' => '2025-12-31 23:59:59',
            ],
        ];
    }
}
