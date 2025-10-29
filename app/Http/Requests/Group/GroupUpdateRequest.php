<?php

namespace App\Http\Requests\Group;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $group = $this->route('group');

        return $this->user()?->can('update', $group) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:3', 'max:128'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_public' => ['nullable', 'boolean'],
            'cover_image' => ['nullable', 'string', 'url', 'max:248'],
            'rules' => ['nullable', 'string', 'max:10000'],
            'is_active' => ['nullable', 'boolean'],
            'join_policy' => ['nullable', Rule::enum(JoinPolicy::class)],
            'post_policy' => ['nullable', Rule::enum(PostPolicy::class)],
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
