<?php

namespace App\Http\Requests\GroupPoll;

use App\Models\GroupPoll;
use Illuminate\Foundation\Http\FormRequest;

class GroupPollIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', GroupPoll::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:question,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_id' => ['nullable', 'string', 'exists:groups,id'],
            'creator_id' => ['nullable', 'string', 'exists:users,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для питання опитування.',
                'example' => 'Яка книга найкраща?',
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
                'example' => 'question',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'group_id' => [
                'description' => 'Фільтр за ID групи.',
                'example' => 'group-uuid123',
            ],
            'creator_id' => [
                'description' => 'Фільтр за ID творця опитування.',
                'example' => 'user-uuid123',
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
