<?php

namespace App\Http\Requests\GroupPost;

use App\Models\GroupPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupPostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', GroupPost::class);
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'string', 'exists:groups,id'],
            'user_id' => ['required', 'string', 'exists:users,id'],
            'content' => ['required', 'string'],
            'is_pinned' => ['boolean'],
            'category' => ['nullable', Rule::in(\App\Enums\PostCategory::values())],
            'post_status' => ['nullable', Rule::in(\App\Enums\PostStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'ID групи, до якої відноситься пост.',
                'example' => 'group-uuid123',
            ],
            'user_id' => [
                'description' => 'ID користувача, який створює пост.',
                'example' => 'user-uuid123',
            ],
            'content' => [
                'description' => 'Вміст поста.',
                'example' => 'Обговорюємо нову книгу!',
            ],
            'is_pinned' => [
                'description' => 'Чи є пост закріпленим.',
                'example' => false,
            ],
            'category' => [
                'description' => 'Категорія поста.',
                'example' => 'DISCUSSION',
            ],
            'post_status' => [
                'description' => 'Статус поста.',
                'example' => 'PUBLISHED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
