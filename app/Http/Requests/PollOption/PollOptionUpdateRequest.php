<?php

namespace App\Http\Requests\PollOption;

use Illuminate\Foundation\Http\FormRequest;

class PollOptionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('pollOption')) ?? false;
    }

    public function rules(): array
    {
        return [
            'text' => ['required', 'string', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'text' => [
                'description' => 'Оновлений текст варіанта відповіді.',
                'example' => 'Варіант відповіді 1 (оновлено)',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'pollOption' => [
                'description' => 'UUID варіанта опитування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
