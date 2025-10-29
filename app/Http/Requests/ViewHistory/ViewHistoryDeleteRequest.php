<?php

namespace App\Http\Requests\ViewHistory;

use Illuminate\Foundation\Http\FormRequest;

class ViewHistoryDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $viewHistory = $this->route('view_history');

        return $this->user()?->can('delete', $viewHistory) ?? false;
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
            'view_history' => [
                'description' => 'ID запису історії переглядів, який потрібно видалити.',
                'example' => 'uuid-123',
            ],
        ];
    }
}
