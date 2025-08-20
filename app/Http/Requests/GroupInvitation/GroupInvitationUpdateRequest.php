<?php

namespace App\Http\Requests\GroupInvitation;

use App\Models\GroupInvitation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupInvitationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupInvitation = $this->route('group_invitation');
        return $this->user()->can('update', $groupInvitation);
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::in(\App\Enums\InvitationStatus::values())],
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
