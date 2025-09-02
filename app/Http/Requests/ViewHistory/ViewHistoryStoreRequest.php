<?php

namespace App\Http\Requests\ViewHistory;

use App\Models\ViewHistory;
use Illuminate\Foundation\Http\FormRequest;

class ViewHistoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', ViewHistory::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'viewable_id' => ['required', 'string', 'max:255'],
            'viewable_type' => ['required', 'string', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який переглянув об’єкт.',
                'example' => 'user-uuid123',
            ],
            'viewable_id' => [
                'description' => 'ID переглянутого об’єкта.',
                'example' => 'post-uuid123',
            ],
            'viewable_type' => [
                'description' => 'Тип переглянутого об’єкта (наприклад, App\\Models\\Post).',
                'example' => 'App\\Models\\Post',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
