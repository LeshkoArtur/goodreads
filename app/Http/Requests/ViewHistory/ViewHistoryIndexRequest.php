<?php

namespace App\Http\Requests\ViewHistory;

use Illuminate\Foundation\Http\FormRequest;

class ViewHistoryIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', \App\Models\ViewHistory::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'max:255'],
            'direction' => ['nullable', 'in:asc,desc'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'viewable_type' => ['nullable', 'string', 'max:255'],
            'viewable_id' => ['nullable', 'uuid'],
            'min_viewed_at' => ['nullable', 'date'],
            'max_viewed_at' => ['nullable', 'date'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит',
                'example' => 'Some search text',
            ],
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
                'description' => 'Тип переглянутого об’єкта',
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
