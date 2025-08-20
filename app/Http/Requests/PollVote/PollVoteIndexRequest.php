<?php

namespace App\Http\Requests\PollVote;

use App\Models\PollVote;
use Illuminate\Foundation\Http\FormRequest;

class PollVoteIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', PollVote::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_poll_id' => ['nullable', 'string', 'exists:group_polls,id'],
            'poll_option_id' => ['nullable', 'string', 'exists:poll_options,id'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для голосів в опитуванні.',
                'example' => 'Голоси користувача',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість голосів на сторінці.',
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
            'group_poll_id' => [
                'description' => 'Фільтр за ID опитування.',
                'example' => 'poll-uuid123',
            ],
            'poll_option_id' => [
                'description' => 'Фільтр за ID варіанту опитування.',
                'example' => 'option-uuid123',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача, який проголосував.',
                'example' => 'user-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
