<?php

namespace App\Http\Requests\GroupPoll;

use App\Models\GroupPoll;
use Illuminate\Foundation\Http\FormRequest;

class GroupPollStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', GroupPoll::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'uuid', 'exists:groups,id'],
            'question' => ['required', 'string', 'max:500'],
            'options' => ['required', 'array', 'min:2', 'max:10'],
            'options.*' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'UUID групи, для якої створюється опитування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'question' => [
                'description' => 'Питання опитування.',
                'example' => 'Яка ваша улюблена книга місяця?',
            ],
            'options' => [
                'description' => 'Масив варіантів відповіді (мінімум 2, максимум 10).',
                'example' => '["Варіант 1", "Варіант 2", "Варіант 3"]',
            ],
            'is_active' => [
                'description' => 'Чи активне опитування.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
