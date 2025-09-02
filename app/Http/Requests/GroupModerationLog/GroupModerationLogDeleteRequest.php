<?php

namespace App\Http\Requests\GroupModerationLog;

use App\Models\GroupModerationLog;
use Illuminate\Foundation\Http\FormRequest;

class GroupModerationLogDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupModerationLog = $this->route('group_moderation_log');
        return $this->user()->can('delete', $groupModerationLog);
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'group_moderation_log' => [
                'description' => 'ID логу модерації для видалення.',
                'example' => 'log-uuid123',
            ],
        ];
    }
}
