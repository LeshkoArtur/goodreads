<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Comment::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'commentable_type' => ['required', 'string', 'in:App\Models\Book,App\Models\Post'],
            'commentable_id' => ['required', 'string'],
            'content' => ['required', 'string'],
            'parent_id' => ['nullable', 'string', 'exists:comments,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який створює коментар.',
                'example' => 'user-uuid123',
            ],
            'commentable_type' => [
                'description' => 'Тип коментованого об’єкта (напр., App\Models\Book).',
                'example' => 'App\Models\Book',
            ],
            'commentable_id' => [
                'description' => 'ID коментованого об’єкта.',
                'example' => 'book-uuid123',
            ],
            'content' => [
                'description' => 'Текст коментаря.',
                'example' => 'Дуже цікава книга!',
            ],
            'parent_id' => [
                'description' => 'ID батьківського коментаря (для відповідей).',
                'example' => 'comment-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
