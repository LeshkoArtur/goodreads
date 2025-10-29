<?php

namespace App\Http\Requests\GroupPoll;

use Illuminate\Foundation\Http\FormRequest;

class GroupPollUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('groupPoll')) ?? false;
    }

    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'question' => [
                'description' => 'Оновлене питання опитування.',
                'example' => 'Яка ваша улюблена книга місяця? (оновлено)',
            ],
            'is_active' => [
                'description' => 'Чи активне опитування.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'groupPoll' => [
                'description' => 'UUID опитування групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
