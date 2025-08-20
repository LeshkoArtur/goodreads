<?php

namespace App\Http\Requests\GroupPost;

use App\Models\GroupPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupPostUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupPost = $this->route('group_post');
        return $this->user()->can('update', $groupPost);
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'is_pinned' => ['nullable', 'boolean'],
            'category' => ['nullable', Rule::in(\App\Enums\PostCategory::values())],
            'status' => ['nullable', Rule::in(\App\Enums\PostStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва поста.',
                'example' => 'Обговорення книги',
            ],
            'body' => [
                'description' => 'Вміст поста.',
                'example' => 'Оновлений текст поста про нову книгу.',
            ],
            'is_pinned' => [
                'description' => 'Чи є пост закріпленим.',
                'example' => true,
            ],
            'category' => [
                'description' => 'Категорія поста.',
                'example' => 'DISCUSSION',
            ],
            'status' => [
                'description' => 'Статус поста.',
                'example' => 'PUBLISHED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'group_post' => [
                'description' => 'ID поста групи для оновлення.',
                'example' => 'post-uuid123',
            ],
        ];
    }
}
