<?php

namespace App\Http\Requests\Nomination;

use App\Models\Nomination;
use Illuminate\Foundation\Http\FormRequest;

class NominationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Nomination::class);
    }

    public function rules(): array
    {
        return [
            'award_id' => ['required', 'string', 'exists:awards,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'award_id' => [
                'description' => 'ID нагороди, до якої відноситься номінація.',
                'example' => 'award-uuid123',
            ],
            'name' => [
                'description' => 'Назва номінації.',
                'example' => 'Найкраща книга року',
            ],
            'description' => [
                'description' => 'Опис номінації.',
                'example' => 'Номінація для найкращих літературних творів року.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
