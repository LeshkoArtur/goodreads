<?php

namespace App\Http\Requests\PollOption;

use App\Models\PollOption;
use Illuminate\Foundation\Http\FormRequest;

class PollOptionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', PollOption::class);
    }

    public function rules(): array
    {
        return [
            'group_poll_id' => ['required', 'string', 'exists:group_polls,id'],
            'text' => ['required', 'string', 'max:255'],
            'vote_count' => ['integer', 'min:0'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_poll_id' => [
                'description' => 'ID опитування, до якого відноситься варіант.',
                'example' => 'poll-uuid123',
            ],
            'text' => [
                'description' => 'Текст варіанту опитування.',
                'example' => 'Варіант 1',
            ],
            'vote_count' => [
                'description' => 'Кількість голосів за варіант.',
                'example' => 0,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
