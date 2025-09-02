<?php

namespace App\Http\Requests\Favorite;

use App\Models\Favorite;
use Illuminate\Foundation\Http\FormRequest;

class FavoriteIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Favorite::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'favoriteable_type' => ['nullable', 'string', 'in:App\Models\Book,App\Models\Author,App\Models\Series'],
            'favoriteable_id' => ['nullable', 'string'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для улюблених об’єктів.',
                'example' => 'Улюблені книги',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість улюблених на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача.',
                'example' => 'user-uuid123',
            ],
            'favoriteable_type' => [
                'description' => 'Фільтр за типом улюбленого об’єкта (напр., App\Models\Book).',
                'example' => 'App\Models\Book',
            ],
            'favoriteable_id' => [
                'description' => 'Фільтр за ID улюбленого об’єкта.',
                'example' => 'book-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
