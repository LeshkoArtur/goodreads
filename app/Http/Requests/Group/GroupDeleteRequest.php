<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class GroupDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $group = $this->route('group');

        return $this->user()?->can('delete', $group) ?? false;
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
            'group' => [
                'description' => 'ID групи для видалення.',
                'example' => 'group-uuid123',
            ],
        ];
    }
}
