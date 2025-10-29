<?php

namespace App\Http\Requests\GroupInvitation;

use App\Enums\InvitationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupInvitationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupInvitation = $this->route('group_invitation');

        return $this->user()?->can('update', $groupInvitation) ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::enum(InvitationStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'status' => [
                'description' => 'Статус запрошення.',
                'example' => 'ACCEPTED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'group_invitation' => [
                'description' => 'ID запрошення до групи для оновлення.',
                'example' => 'invitation-uuid123',
            ],
        ];
    }
}
