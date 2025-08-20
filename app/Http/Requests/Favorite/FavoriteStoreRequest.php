<?php

namespace App\Http\Requests\Favorite;

use App\Models\Favorite;
use Illuminate\Foundation\Http\FormRequest;

class FavoriteStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Favorite::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'favoriteable_id' => ['required', 'string'],
            'favoriteable_type' => ['required', 'string', 'in:App\Models\Book,App\Models\Author,App\Models\Series'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який додає об’єкт до улюблених.',
                'example' => 'user-uuid123',
            ],
            'favoriteable_id' => [
                'description' => 'ID об’єкта, що додається до улюблених.',
                'example' => 'book-uuid123',
            ],
            'favoriteable_type' => [
                'description' => 'Тип об’єкта, що додається до улюблених (напр., App\Models\Book).',
                'example' => 'App\Models\Book',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
