<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CommentDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('delete', $this->route('comment')) ?? false;
    }

    public function rules(): array
    {
        return [];
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
