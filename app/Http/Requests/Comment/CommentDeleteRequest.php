<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $comment = $this->route('comment');
        return $this->user()->can('delete', $comment);
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'comment' => [
                'description' => 'ID коментаря для видалення.',
                'example' => 'comment-uuid123',
            ],
        ];
    }
}
