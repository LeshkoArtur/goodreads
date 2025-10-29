<?php

namespace App\Http\Requests\Favorite;

use App\Models\Favorite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FavoriteToggleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Favorite::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'favoriteable_type' => [
                'required',
                'string',
                'max:255',
                Rule::in([
                    'App\\Models\\Book',
                    'App\\Models\\Post',
                    'App\\Models\\GroupPost',
                    'App\\Models\\Quote',
                    'App\\Models\\Rating',
                ]),
            ],
            'favoriteable_id' => ['required', 'uuid'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'favoriteable_type' => [
                'description' => 'Тип об\'єкта для toggle улюбленого. Можливі значення: App\\Models\\Book, App\\Models\\Post, App\\Models\\GroupPost, App\\Models\\Quote, App\\Models\\Rating.',
                'example' => 'App\\Models\\Book',
            ],
            'favoriteable_id' => [
                'description' => 'UUID об\'єкта для toggle улюбленого.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
