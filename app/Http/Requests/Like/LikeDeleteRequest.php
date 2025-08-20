<?php

namespace App\Http\Requests\Like;

use App\Models\Like;
use Illuminate\Foundation\Http\FormRequest;

class LikeDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $like = $this->route('like');
        return $this->user()->can('delete', $like);
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
            'like' => [
                'description' => 'ID лайка для видалення.',
                'example' => 'like-uuid123',
            ],
        ];
    }
}
