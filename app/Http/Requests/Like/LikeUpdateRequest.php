<?php

namespace App\Http\Requests\Like;

use App\Models\Like;
use Illuminate\Foundation\Http\FormRequest;

class LikeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $like = $this->route('like');
        return $this->user()->can('update', $like);
    }

    public function rules(): array
    {
        return [
            'likeable_type' => ['nullable', 'string', 'in:App\Models\GroupPost,App\Models\Comment'],
            'likeable_id' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'likeable_type' => [
                'description' => 'Тип лайкнутого об’єкта (напр., App\Models\GroupPost).',
                'example' => 'App\Models\GroupPost',
            ],
            'likeable_id' => [
                'description' => 'ID лайкнутого об’єкта.',
                'example' => 'post-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'like' => [
                'description' => 'ID лайка для оновлення.',
                'example' => 'like-uuid123',
            ],
        ];
    }
}
