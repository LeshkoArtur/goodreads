<?php

namespace App\Http\Requests\GroupInvitation;

use App\Models\GroupInvitation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupInvitationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', GroupInvitation::class);
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'string', 'exists:groups,id'],
            'inviter_id' => ['required', 'string', 'exists:users,id'],
            'invitee_id' => ['required', 'string', 'exists:users,id'],
            'status' => ['nullable', Rule::in(\App\Enums\InvitationStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'ID групи, до якої запрошують.',
                'example' => 'group-uuid123',
            ],
            'inviter_id' => [
                'description' => 'ID користувача, який надсилає запрошення.',
                'example' => 'user-uuid123',
            ],
            'invitee_id' => [
                'description' => 'ID користувача, якого запрошують.',
                'example' => 'user-uuid456',
            ],
            'status' => [
                'description' => 'Статус запрошення.',
                'example' => 'PENDING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
