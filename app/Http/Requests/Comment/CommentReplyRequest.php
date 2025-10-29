<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Comment::class) ?? false;
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
                'description' => 'Текст відповіді на коментар.',
                'example' => 'Дякую за коментар! Повністю згоден.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'comment' => [
                'description' => 'UUID коментаря, на який відповідаємо.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
