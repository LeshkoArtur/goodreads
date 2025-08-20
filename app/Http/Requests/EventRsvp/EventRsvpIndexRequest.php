<?php

namespace App\Http\Requests\EventRsvp;

use App\Models\EventRsvp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRsvpIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', EventRsvp::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_event_id' => ['nullable', 'string', 'exists:group_events,id'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'response' => ['nullable', Rule::in(\App\Enums\EventResponse::values())],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для RSVP на подію.',
                'example' => 'Відвідування події',
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
                'description' => 'Фільтр за ID події групи.',
                'example' => 'event-uuid123',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача.',
                'example' => 'user-uuid123',
            ],
            'response' => [
                'description' => 'Фільтр за типом відповіді на подію.',
                'example' => 'GOING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
