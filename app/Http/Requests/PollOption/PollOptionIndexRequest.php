<?php

namespace App\Http\Requests\PollOption;

use App\Models\PollOption;
use Illuminate\Foundation\Http\FormRequest;

class PollOptionIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', PollOption::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at,vote_count'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_poll_id' => ['nullable', 'uuid', 'exists:group_polls,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для тексту варіанта.',
                'example' => 'Варіант',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість варіантів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at, vote_count).',
                'example' => 'vote_count',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'group_poll_id' => [
                'description' => 'Фільтр за UUID опитування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
