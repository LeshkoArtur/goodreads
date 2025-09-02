<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $comment = $this->route('comment');
        return $this->user()->can('update', $comment);
    }

    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'is_spoiler' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'body' => [
                'description' => 'Текст коментаря.',
                'example' => 'Оновлений текст коментаря...',
            ],
            'is_spoiler' => [
                'description' => 'Чи містить коментар спойлери.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'comment' => [
                'description' => 'ID коментаря для оновлення.',
                'example' => 'comment-uuid123',
            ],
        ];
    }
}
