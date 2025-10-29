<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $post = $this->route('post');

        return $this->user()?->can('delete', $post) ?? false;
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
            'post' => [
                'description' => 'ID поста для видалення.',
                'example' => 'post-uuid123',
            ],
        ];
    }
}
