<?php

namespace App\Http\Requests\GroupModerationLog;

use App\Models\GroupModerationLog;
use Illuminate\Foundation\Http\FormRequest;

class GroupModerationLogUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupModerationLog = $this->route('group_moderation_log');
        return $this->user()->can('update', $groupModerationLog);
    }

    public function rules(): array
    {
        return [
            'action' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'action' => [
                'description' => 'Дія модерації.',
                'example' => 'UPDATE_POST',
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
