<?php

namespace App\Http\Requests\GroupEvent;

use App\Enums\EventStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupEventUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('groupEvent')) ?? false;
    }

    public function rules(): array
    {
        return [
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
            'title' => [
                'description' => 'Оновлена назва події.',
                'example' => 'Зустріч книжкового клубу (оновлено)',
            ],
            'description' => [
                'description' => 'Оновлений опис події.',
                'example' => 'Обговорення нової книги місяця та чаювання',
            ],
            'event_date' => [
                'description' => 'Оновлена дата та час події.',
                'example' => '2025-11-15 18:00:00',
            ],
            'location' => [
                'description' => 'Оновлена локація події.',
                'example' => 'Київ, вул. Хрещатик 1',
            ],
            'status' => [
                'description' => 'Оновлений статус події.',
                'example' => 'upcoming',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'groupEvent' => [
                'description' => 'UUID події групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
