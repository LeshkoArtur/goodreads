<?php

namespace App\Http\Requests\Favorite;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $favorite = $this->route('favorite');

        return $this->user()?->can('update', $favorite) ?? false;
    }

    public function rules(): array
    {
        return [
            'favoriteable_type' => ['nullable', 'string', 'in:App\Models\Book,App\Models\Author,App\Models\Series'],
            'favoriteable_id' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'favoriteable_type' => [
                'description' => 'Тип улюбленого об’єкта. Можливі значення: App\Models\Book, App\Models\Author, App\Models\Series.',
                'example' => 'App\Models\Book',
            ],
            'favoriteable_id' => [
                'description' => 'ID улюбленого об’єкта.',
                'example' => 'book-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'favorite' => [
                'description' => 'ID улюбленого для оновлення.',
                'example' => 'favorite-uuid123',
            ],
        ];
    }
}
