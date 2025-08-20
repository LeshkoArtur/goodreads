<?php

namespace App\Http\Requests\Like;

use App\Models\Like;
use Illuminate\Foundation\Http\FormRequest;

class LikeIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Like::class);
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
            'likeable_type' => ['nullable', 'string', 'in:App\Models\GroupPost,App\Models\Comment'],
            'likeable_id' => ['nullable', 'string'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для лайків.',
                'example' => 'Лайки постів',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість лайків на сторінці.',
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
                'description' => 'Фільтр за ID користувача, який поставив лайк.',
                'example' => 'user-uuid123',
            ],
            'likeable_type' => [
                'description' => 'Фільтр за типом лайкнутого об’єкта (напр., App\Models\GroupPost).',
                'example' => 'App\Models\GroupPost',
            ],
            'likeable_id' => [
                'description' => 'Фільтр за ID лайкнутого об’єкта.',
                'example' => 'post-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
