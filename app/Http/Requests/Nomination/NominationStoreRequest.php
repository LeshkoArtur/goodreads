<?php

namespace App\Http\Requests\Nomination;

use App\Models\Nomination;
use Illuminate\Foundation\Http\FormRequest;

class NominationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Nomination::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'award_id' => ['required', 'uuid', 'exists:awards,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'award_id' => [
                'description' => 'UUID нагороди.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'name' => [
                'description' => 'Назва номінації.',
                'example' => 'Найкраща книга року',
            ],
            'description' => [
                'description' => 'Опис номінації.',
                'example' => 'Номінація для найкращої художньої книги року.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
