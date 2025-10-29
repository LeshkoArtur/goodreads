<?php

namespace App\Http\Requests\Like;

use App\Models\Like;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LikeStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Like::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'likeable_type' => [
                'required',
                'string',
                'max:255',
                Rule::in([
                    'App\\Models\\Post',
                    'App\\Models\\GroupPost',
                    'App\\Models\\Quote',
                    'App\\Models\\Rating',
                    'App\\Models\\Comment',
                    'App\\Models\\AuthorAnswer',
                ]),
            ],
            'likeable_id' => ['required', 'uuid'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'likeable_type' => [
                'description' => 'Тип об\'єкта для лайка. Можливі значення: App\\Models\\Post, App\\Models\\GroupPost, App\\Models\\Quote, App\\Models\\Rating, App\\Models\\Comment, App\\Models\\AuthorAnswer.',
                'example' => 'App\\Models\\Post',
            ],
            'likeable_id' => [
                'description' => 'UUID об\'єкта для лайка.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
