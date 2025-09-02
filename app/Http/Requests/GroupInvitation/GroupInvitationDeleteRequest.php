<?php

namespace App\Http\Requests\GroupInvitation;

use App\Models\GroupInvitation;
use Illuminate\Foundation\Http\FormRequest;

class GroupInvitationDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupInvitation = $this->route('group_invitation');
        return $this->user()->can('delete', $groupInvitation);
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
            'group_invitation' => [
                'description' => 'ID запрошення до групи для видалення.',
                'example' => 'invitation-uuid123',
            ],
        ];
    }
}
