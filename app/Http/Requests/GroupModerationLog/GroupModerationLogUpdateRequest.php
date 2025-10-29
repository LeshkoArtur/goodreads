<?php

namespace App\Http\Requests\GroupModerationLog;

use App\Enums\ModerationAction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupModerationLogUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupModerationLog = $this->route('group_moderation_log');

        return $this->user()?->can('update', $groupModerationLog) ?? false;
    }

    public function rules(): array
    {
        return [
            'action' => ['nullable', Rule::enum(ModerationAction::class)],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'action' => [
                'description' => 'Дія модерації. Можливі значення: delete, approve, reject, warning, ban, unban, pin, unpin, edit, move.',
                'example' => 'edit',
            ],
            'description' => [
                'description' => 'Опис дії модерації.',
                'example' => 'Оновлено опис дії модерації.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'group_moderation_log' => [
                'description' => 'ID логу модерації для оновлення.',
                'example' => 'log-uuid123',
            ],
        ];
    }
}
