<?php

namespace App\Http\Requests\GroupPost;

use App\Models\GroupPost;
use Illuminate\Foundation\Http\FormRequest;

class GroupPostDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupPost = $this->route('group_post');
        return $this->user()->can('delete', $groupPost);
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
            'group_post' => [
                'description' => 'ID поста групи для видалення.',
                'example' => 'post-uuid123',
            ],
        ];
    }
}
