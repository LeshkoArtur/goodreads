<?php

namespace App\Http\Requests\GroupPost;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use App\Models\GroupPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupPostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', GroupPost::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'uuid', 'exists:groups,id'],
            'content' => ['required', 'string', 'max:10000'],
            'is_pinned' => ['nullable', 'boolean'],
            'category' => ['nullable', Rule::enum(PostCategory::class)],
            'post_status' => ['nullable', Rule::enum(PostStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'UUID групи, в якій створюється пост.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'content' => [
                'description' => 'Контент посту.',
                'example' => 'Це чудовий пост для нашої групи!',
            ],
            'is_pinned' => [
                'description' => 'Чи закріплений пост.',
                'example' => false,
            ],
            'category' => [
                'description' => 'Категорія посту.',
                'example' => 'general',
            ],
            'post_status' => [
                'description' => 'Статус посту.',
                'example' => 'published',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
