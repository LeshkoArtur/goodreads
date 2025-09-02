<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $post = $this->route('post');
        return $this->user()->can('update', $post);
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'type' => ['nullable', Rule::in(\App\Enums\PostType::values())],
            'status' => ['nullable', Rule::in(\App\Enums\PostStatus::values())],
            'published_at' => ['nullable', 'date'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['string', 'exists:tags,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва поста.',
                'example' => 'Оновлений огляд книги',
            ],
            'body' => [
                'description' => 'Текст поста.',
                'example' => 'Оновлений текст огляду...',
            ],
            'type' => [
                'description' => 'Тип поста.',
                'example' => 'ARTICLE',
            ],
            'status' => [
                'description' => 'Статус поста.',
                'example' => 'PUBLISHED',
            ],
            'published_at' => [
                'description' => 'Дата публікації поста у форматі Y-m-d H:i:s.',
                'example' => '2023-01-01 12:00:00',
            ],
            'tag_ids' => [
                'description' => 'Масив ID тегів, пов’язаних з постом.',
                'example' => ['tag-uuid123', 'tag-uuid456'],
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'post' => [
                'description' => 'ID поста для оновлення.',
                'example' => 'post-uuid123',
            ],
        ];
    }
}
