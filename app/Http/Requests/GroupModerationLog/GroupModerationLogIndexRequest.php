<?php

namespace App\Http\Requests\GroupModerationLog;

use App\Enums\ModerationAction;
use App\Models\GroupModerationLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupModerationLogIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', GroupModerationLog::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at,action'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'uuid', 'exists:groups,id'],
            'moderator_id' => ['nullable', 'uuid', 'exists:users,id'],
            'action' => ['nullable', Rule::enum(ModerationAction::class)],
            'targetable_type' => ['nullable', 'string'],
            'targetable_id' => ['nullable', 'uuid'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для опису.',
                'example' => 'Видалено пост',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість записів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at, action).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'group_id' => [
                'description' => 'Фільтр за UUID групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'moderator_id' => [
                'description' => 'Фільтр за UUID модератора.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'action' => [
                'description' => 'Фільтр за типом дії модерації. Можливі значення: delete, approve, reject, warning, ban, unban, pin, unpin, edit, move.',
                'example' => 'delete',
            ],
            'targetable_type' => [
                'description' => 'Фільтр за типом об\'єкта модерації. Можливі значення: залежить від контексту (наприклад, App\\Models\\GroupPost, App\\Models\\User, App\\Models\\GroupEvent, тощо).',
                'example' => 'App\\Models\\GroupPost',
            ],
            'targetable_id' => [
                'description' => 'Фільтр за UUID об\'єкта модерації.',
                'example' => '7b5c6d1a-2c3d-4e5f-6a7b-8c9d0e1f2a3b',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
