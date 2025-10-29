<?php

namespace App\Http\Requests\Group;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Group::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:128'],
            'description' => ['nullable', 'string', 'max:5000'],
            'creator_id' => ['required', 'uuid', 'exists:users,id'],
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
