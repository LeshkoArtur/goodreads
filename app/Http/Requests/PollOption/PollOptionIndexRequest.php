<?php

namespace App\Http\Requests\PollOption;

use App\Models\PollOption;
use Illuminate\Foundation\Http\FormRequest;

class PollOptionIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', PollOption::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:text,vote_count,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_poll_id' => ['nullable', 'string', 'exists:group_polls,id'],
            'min_vote_count' => ['nullable', 'integer', 'min:0'],
            'max_vote_count' => ['nullable', 'integer', 'min:0', 'gte:min_vote_count'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для тексту варіанту опитування.',
                'example' => 'Варіант 1',
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
                'description' => 'Поле для сортування (text, vote_count, created_at).',
                'example' => 'vote_count',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'group_poll_id' => [
                'description' => 'Фільтр за ID опитування.',
                'example' => 'poll-uuid123',
            ],
            'min_vote_count' => [
                'description' => 'Мінімальна кількість голосів для фільтрації.',
                'example' => 0,
            ],
            'max_vote_count' => [
                'description' => 'Максимальна кількість голосів для фільтрації.',
                'example' => 100,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
