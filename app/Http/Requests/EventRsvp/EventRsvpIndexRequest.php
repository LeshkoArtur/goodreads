<?php

namespace App\Http\Requests\EventRsvp;

use App\Enums\EventResponse;
use App\Models\EventRsvp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRsvpIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', EventRsvp::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_event_id' => ['nullable', 'uuid', 'exists:group_events,id'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'response' => ['nullable', Rule::enum(EventResponse::class)],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит.',
                'example' => '',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість RSVP на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'group_event_id' => [
                'description' => 'Фільтр за UUID події групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'user_id' => [
                'description' => 'Фільтр за UUID користувача.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'response' => [
                'description' => 'Фільтр за відповіддю на запрошення.',
                'example' => 'going',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
