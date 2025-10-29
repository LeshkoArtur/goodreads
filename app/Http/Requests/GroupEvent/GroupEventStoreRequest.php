<?php

namespace App\Http\Requests\GroupEvent;

use App\Enums\EventStatus;
use App\Models\GroupEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupEventStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', GroupEvent::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'uuid', 'exists:groups,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::enum(EventStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'UUID групи, для якої створюється подія.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'title' => [
                'description' => 'Назва події.',
                'example' => 'Зустріч книжкового клубу',
            ],
            'description' => [
                'description' => 'Опис події.',
                'example' => 'Обговорення нової книги місяця',
            ],
            'event_date' => [
                'description' => 'Дата та час події.',
                'example' => '2025-11-15 18:00:00',
            ],
            'location' => [
                'description' => 'Локація події.',
                'example' => 'Київ, вул. Хрещатик 1',
            ],
            'status' => [
                'description' => 'Статус події.',
                'example' => 'upcoming',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
