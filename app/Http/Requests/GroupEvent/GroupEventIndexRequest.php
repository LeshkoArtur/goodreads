<?php

namespace App\Http\Requests\GroupEvent;

use App\Enums\EventStatus;
use App\Models\GroupEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupEventIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', GroupEvent::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:title,event_date,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'uuid', 'exists:groups,id'],
            'creator_id' => ['nullable', 'uuid', 'exists:users,id'],
            'status' => ['nullable', Rule::enum(EventStatus::class)],
            'location' => ['nullable', 'string', 'max:255'],
            'min_event_date' => ['nullable', 'date'],
            'max_event_date' => ['nullable', 'date'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису події.',
                'example' => 'Зустріч книжкового клубу',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість подій на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (title, event_date, created_at).',
                'example' => 'event_date',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'group_id' => [
                'description' => 'Фільтр за UUID групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'creator_id' => [
                'description' => 'Фільтр за UUID створювача події.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'status' => [
                'description' => 'Фільтр за статусом події.',
                'example' => 'upcoming',
            ],
            'location' => [
                'description' => 'Фільтр за локацією події.',
                'example' => 'Київ',
            ],
            'min_event_date' => [
                'description' => 'Мінімальна дата події.',
                'example' => '2025-01-01',
            ],
            'max_event_date' => [
                'description' => 'Максимальна дата події.',
                'example' => '2025-12-31',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
