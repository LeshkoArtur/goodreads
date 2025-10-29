<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Comment::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:5000'],
            'commentable_type' => [
                'required',
                'string',
                'max:255',
                Rule::in([
                    'App\\Models\\Post',
                    'App\\Models\\GroupPost',
                    'App\\Models\\Quote',
                    'App\\Models\\Rating',
                ]),
            ],
            'commentable_id' => ['required', 'uuid'],
            'parent_id' => ['nullable', 'uuid', 'exists:comments,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'content' => [
                'description' => 'Текст коментаря.',
                'example' => 'Це чудова книга, дуже рекомендую!',
            ],
            'commentable_type' => [
                'description' => 'Тип об\'єкта для коментування. Можливі значення: App\\Models\\Post, App\\Models\\GroupPost, App\\Models\\Quote, App\\Models\\Rating.',
                'example' => 'App\\Models\\Post',
            ],
            'commentable_id' => [
                'description' => 'UUID об\'єкта для коментування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'parent_id' => [
                'description' => 'UUID батьківського коментаря (для відповідей).',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
