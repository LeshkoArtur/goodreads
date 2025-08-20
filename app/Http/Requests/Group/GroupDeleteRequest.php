<?php

namespace App\Http\Requests\Group;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;

class GroupDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $group = $this->route('group');
        return $this->user()->can('delete', $group);
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
