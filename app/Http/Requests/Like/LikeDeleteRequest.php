<?php

namespace App\Http\Requests\Like;

use Illuminate\Foundation\Http\FormRequest;

class LikeDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('delete', $this->route('like')) ?? false;
    }

    public function rules(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'like' => [
                'description' => 'UUID лайка.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
