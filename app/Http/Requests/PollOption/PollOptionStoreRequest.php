<?php

namespace App\Http\Requests\PollOption;

use App\Models\PollOption;
use Illuminate\Foundation\Http\FormRequest;

class PollOptionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', PollOption::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'group_poll_id' => ['required', 'uuid', 'exists:group_polls,id'],
            'text' => ['required', 'string', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_poll_id' => [
                'description' => 'UUID опитування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'text' => [
                'description' => 'Текст варіанта відповіді.',
                'example' => 'Варіант відповіді 1',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
