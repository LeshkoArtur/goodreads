<?php

namespace App\Http\Requests\GroupEvent;

use App\Models\GroupEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupEventStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', GroupEvent::class);
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'string', 'exists:groups,id'],
            'creator_id' => ['required', 'string', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(\App\Enums\EventStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'ID групи, до якої відноситься подія.',
                'example' => 'group-uuid123',
            ],
            'creator_id' => [
                'description' => 'ID користувача, який створює подію.',
                'example' => 'user-uuid123',
            ],
            'title' => [
                'description' => 'Назва події.',
                'example' => 'Обговорення нової книги',
            ],
            'description' => [
                'description' => 'Опис події.',
                'example' => 'Зустріч для обговорення фентезійної літератури.',
            ],
            'event_date' => [
                'description' => 'Дата і час події у форматі Y-m-d H:i:s.',
                'example' => '2025-08-13 18:00:00',
            ],
            'location' => [
                'description' => 'Місце проведення події.',
                'example' => 'Київ, бібліотека',
            ],
            'status' => [
                'description' => 'Статус події.',
                'example' => 'UPCOMING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
