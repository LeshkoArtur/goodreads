<?php

namespace App\Http\Requests\Nomination;

use Illuminate\Foundation\Http\FormRequest;

class NominationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('nomination')) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Оновлена назва номінації.',
                'example' => 'Найкраща книга року',
            ],
            'description' => [
                'description' => 'Оновлений опис номінації.',
                'example' => 'Номінація для найкращої художньої книги року.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'nomination' => [
                'description' => 'UUID номінації.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
