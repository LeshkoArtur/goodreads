<?php

namespace App\Http\Requests\GroupEvent;

use App\Models\GroupEvent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupEventIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', GroupEvent::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:title,created_at,event_date'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'string', 'exists:groups,id'],
            'creator_id' => ['nullable', 'string', 'exists:users,id'],
            'status' => ['nullable', Rule::in(\App\Enums\EventStatus::values())],
            'min_event_date' => ['nullable', 'date'],
            'max_event_date' => ['nullable', 'date', 'after_or_equal:min_event_date'],
            'location' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису події.',
                'example' => 'Книжковий клуб',
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
                'description' => 'Поле для сортування (title, created_at, event_date).',
                'example' => 'title',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'group_id' => [
                'description' => 'Фільтр за ID групи.',
                'example' => 'group-uuid123',
            ],
            'creator_id' => [
                'description' => 'Фільтр за ID творця події.',
                'example' => 'user-uuid123',
            ],
            'status' => [
                'description' => 'Фільтр за статусом події.',
                'example' => 'UPCOMING',
            ],
            'min_event_date' => [
                'description' => 'Мінімальна дата події для фільтрації.',
                'example' => '2025-08-13 18:00:00',
            ],
            'max_event_date' => [
                'description' => 'Максимальна дата події для фільтрації.',
                'example' => '2025-12-31 23:59:59',
            ],
            'location' => [
                'description' => 'Фільтр за місцем проведення події.',
                'example' => 'Київ, бібліотека',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
