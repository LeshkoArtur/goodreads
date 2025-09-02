<?php

namespace App\Http\Requests\GroupEvent;

use App\Models\GroupEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupEventUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupEvent = $this->route('group_event');
        return $this->user()->can('update', $groupEvent);
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(\App\Enums\EventStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва події.',
                'example' => 'Обговорення нової книги',
            ],
            'description' => [
                'description' => 'Опис події.',
                'example' => 'Оновлений опис зустрічі для обговорення літератури.',
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
        return [
            'group_event' => [
                'description' => 'ID події групи для оновлення.',
                'example' => 'event-uuid123',
            ],
        ];
    }
}
