<?php

namespace App\Http\Requests\Group;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $group = $this->route('group');
        return $this->user()->can('update', $group);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'is_public' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'join_policy' => ['nullable', Rule::in(\App\Enums\JoinPolicy::values())],
            'post_policy' => ['nullable', Rule::in(\App\Enums\PostPolicy::values())],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва групи.',
                'example' => 'Клуб любителів фентезі',
            ],
            'is_public' => [
                'description' => 'Чи є група публічною.',
                'example' => true,
            ],
            'is_active' => [
                'description' => 'Чи є група активною.',
                'example' => true,
            ],
            'join_policy' => [
                'description' => 'Політика приєднання до групи.',
                'example' => 'OPEN',
            ],
            'post_policy' => [
                'description' => 'Політика публікацій у групі.',
                'example' => 'MEMBER',
            ],
            'description' => [
                'description' => 'Опис групи.',
                'example' => 'Оновлений опис групи для любителів фентезі.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'group' => [
                'description' => 'ID групи для оновлення.',
                'example' => 'group-uuid123',
            ],
        ];
    }
}
