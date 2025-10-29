<?php

namespace App\Http\Requests\GroupPost;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupPostUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('groupPost')) ?? false;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:10000'],
            'is_pinned' => ['nullable', 'boolean'],
            'category' => ['nullable', Rule::enum(PostCategory::class)],
            'post_status' => ['nullable', Rule::enum(PostStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'content' => [
                'description' => 'Оновлений контент посту.',
                'example' => 'Це чудовий пост для нашої групи! (оновлено)',
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
        return [
            'groupPost' => [
                'description' => 'UUID посту групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
