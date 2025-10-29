<?php

namespace App\Http\Requests\ViewHistory;

use Illuminate\Foundation\Http\FormRequest;

class ViewHistoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $viewHistory = $this->route('view_history');

        return $this->user()?->can('update', $viewHistory) ?? false;
    }

    public function rules(): array
    {
        return [
            'viewable_id' => ['nullable', 'string', 'max:255'],
            'viewable_type' => ['nullable', 'string', 'max:255'],
            'viewed_at' => ['nullable', 'date'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'viewable_id' => [
                'description' => 'ID переглянутого об’єкта.',
                'example' => 'post-uuid123',
            ],
            'viewable_type' => [
                'description' => 'Тип переглянутого об’єкта. Можливі значення: залежить від вашої моделі (наприклад, App\\Models\\Post, App\\Models\\Book, тощо).',
                'example' => 'App\\Models\\Post',
            ],
            'viewed_at' => [
                'description' => 'Час перегляду у форматі Y-m-d H:i:s.',
                'example' => '2025-08-13 15:30:00',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'view_history' => [
                'description' => 'ID запису історії переглядів.',
                'example' => 'uuid-123',
            ],
        ];
    }
}
