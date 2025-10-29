<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('comment')) ?? false;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:5000'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'content' => [
                'description' => 'Оновлений текст коментаря.',
                'example' => 'Це чудова книга, дуже рекомендую! Оновлено.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'comment' => [
                'description' => 'UUID коментаря.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
