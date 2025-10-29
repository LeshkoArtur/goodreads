<?php

namespace App\Http\Requests\GroupModerationLog;

use App\Enums\ModerationAction;
use App\Models\GroupModerationLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupModerationLogStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', GroupModerationLog::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'uuid', 'exists:groups,id'],
            'action' => ['required', Rule::enum(ModerationAction::class)],
            'targetable_type' => ['required', 'string'],
            'targetable_id' => ['required', 'uuid'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'UUID групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'action' => [
                'description' => 'Тип дії модерації. Можливі значення: delete, approve, reject, warning, ban, unban, pin, unpin, edit, move.',
                'example' => 'delete',
            ],
            'targetable_type' => [
                'description' => 'Тип об\'єкта модерації. Можливі значення: залежить від контексту (наприклад, App\\Models\\GroupPost, App\\Models\\User, App\\Models\\GroupEvent, тощо).',
                'example' => 'App\\Models\\GroupPost',
            ],
            'targetable_id' => [
                'description' => 'UUID об\'єкта модерації.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'description' => [
                'description' => 'Додатковий опис дії модерації.',
                'example' => 'Пост видалено за порушення правил спільноти.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
