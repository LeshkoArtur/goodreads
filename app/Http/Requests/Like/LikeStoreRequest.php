<?php

namespace App\Http\Requests\Like;

use App\Models\Like;
use Illuminate\Foundation\Http\FormRequest;

class LikeStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Like::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'likeable_id' => ['required', 'string'],
            'likeable_type' => ['required', 'string', 'in:App\Models\GroupPost,App\Models\Comment'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який ставить лайк.',
                'example' => 'user-uuid123',
            ],
            'likeable_id' => [
                'description' => 'ID об’єкта, що лайкається.',
                'example' => 'post-uuid123',
            ],
            'likeable_type' => [
                'description' => 'Тип об’єкта, що лайкається (напр., App\Models\GroupPost).',
                'example' => 'App\Models\GroupPost',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
