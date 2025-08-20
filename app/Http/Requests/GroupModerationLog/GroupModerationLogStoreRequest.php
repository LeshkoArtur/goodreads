<?php

namespace App\Http\Requests\GroupModerationLog;

use App\Models\GroupModerationLog;
use Illuminate\Foundation\Http\FormRequest;

class GroupModerationLogStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', GroupModerationLog::class);
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'string', 'exists:groups,id'],
            'moderator_id' => ['required', 'string', 'exists:users,id'],
            'action' => ['required', 'string', 'max:255'],
            'targetable_id' => ['required', 'string'],
            'targetable_type' => ['required', 'string', 'in:App\Models\GroupPost,App\Models\Comment,App\Models\User'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'ID групи, в якій відбулася дія модерації.',
                'example' => 'group-uuid123',
            ],
            'moderator_id' => [
                'description' => 'ID модератора, який виконав дію.',
                'example' => 'user-uuid123',
            ],
            'action' => [
                'description' => 'Дія модерації.',
                'example' => 'DELETE_POST',
            ],
            'targetable_id' => [
                'description' => 'ID цільового об’єкта модерації.',
                'example' => 'post-uuid123',
            ],
            'targetable_type' => [
                'description' => 'Тип цільового об’єкта модерації (напр., App\Models\GroupPost).',
                'example' => 'App\Models\GroupPost',
            ],
            'description' => [
                'description' => 'Опис дії модерації.',
                'example' => 'Пост видалено через порушення правил.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
