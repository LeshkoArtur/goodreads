<?php

namespace App\Http\Requests\PollVote;

use App\Models\PollVote;
use Illuminate\Foundation\Http\FormRequest;

class PollVoteIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', PollVote::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'group_poll_id' => ['nullable', 'uuid', 'exists:group_polls,id'],
            'poll_option_id' => ['nullable', 'uuid', 'exists:poll_options,id'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит.',
                'example' => '',
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
                'description' => 'Фільтр за UUID опитування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'poll_option_id' => [
                'description' => 'Фільтр за UUID варіанта відповіді.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'user_id' => [
                'description' => 'Фільтр за UUID користувача.',
                'example' => '7b5c6d1a-2c3d-4e5f-6a7b-8c9d0e1f2a3b',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
