<?php

namespace App\Http\Requests\GroupPoll;

use App\Models\GroupPoll;
use Illuminate\Foundation\Http\FormRequest;

class GroupPollIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', GroupPoll::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:question,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'uuid', 'exists:groups,id'],
            'creator_id' => ['nullable', 'uuid', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для питання опитування.',
                'example' => 'Яка ваша улюблена книга?',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість опитувань на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (question, created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'group_id' => [
                'description' => 'Фільтр за UUID групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'creator_id' => [
                'description' => 'Фільтр за UUID створювача.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'is_active' => [
                'description' => 'Фільтр за активністю опитування.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
