<?php

namespace App\Http\Requests\GroupModerationLog;

use App\Models\GroupModerationLog;
use Illuminate\Foundation\Http\FormRequest;

class GroupModerationLogIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', GroupModerationLog::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at,action'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'string', 'exists:groups,id'],
            'moderator_id' => ['nullable', 'string', 'exists:users,id'],
            'action' => ['nullable', 'string', 'max:255'],
            'targetable_type' => ['nullable', 'string', 'in:App\Models\GroupPost,App\Models\Comment,App\Models\User'],
            'targetable_id' => ['nullable', 'string'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для дії або опису логу модерації.',
                'example' => 'Видалення коментаря',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість логів на сторінці.',
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
                'description' => 'Фільтр за ID групи.',
                'example' => 'group-uuid123',
            ],
            'moderator_id' => [
                'description' => 'Фільтр за ID модератора.',
                'example' => 'user-uuid123',
            ],
            'action' => [
                'description' => 'Фільтр за дією модерації.',
                'example' => 'DELETE_POST',
            ],
            'targetable_type' => [
                'description' => 'Фільтр за типом цільового об’єкта (напр., App\Models\GroupPost).',
                'example' => 'App\Models\GroupPost',
            ],
            'targetable_id' => [
                'description' => 'Фільтр за ID цільового об’єкта.',
                'example' => 'post-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
