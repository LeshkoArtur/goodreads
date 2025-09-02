<?php

namespace App\Http\Requests\Group;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Group::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'creator_id' => ['required', 'string', 'exists:users,id'],
            'is_public' => ['boolean'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'url'],
            'rules' => ['nullable', 'string'],
            'member_count' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'join_policy' => ['nullable', Rule::in(\App\Enums\JoinPolicy::values())],
            'post_policy' => ['nullable', Rule::in(\App\Enums\PostPolicy::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Назва групи.',
                'example' => 'Клуб любителів фентезі',
            ],
            'creator_id' => [
                'description' => 'ID користувача, який створює групу.',
                'example' => 'user-uuid123',
            ],
            'is_public' => [
                'description' => 'Чи є група публічною.',
                'example' => true,
            ],
            'description' => [
                'description' => 'Опис групи.',
                'example' => 'Група для обговорення фентезійної літератури.',
            ],
            'cover_image' => [
                'description' => 'URL обкладинки групи.',
                'example' => 'https://example.com/cover.jpg',
            ],
            'rules' => [
                'description' => 'Правила групи.',
                'example' => 'Без образ, поважайте інших учасників.',
            ],
            'member_count' => [
                'description' => 'Кількість учасників у групі.',
                'example' => 10,
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
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
