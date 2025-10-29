<?php

namespace App\Http\Requests\GroupInvitation;

use App\Models\GroupInvitation;
use Illuminate\Foundation\Http\FormRequest;

class GroupInvitationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', GroupInvitation::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'uuid', 'exists:groups,id'],
            'invitee_id' => ['required', 'uuid', 'exists:users,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'UUID групи для запрошення.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'invitee_id' => [
                'description' => 'UUID користувача для запрошення.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
