<?php

namespace App\Http\Requests\Award;

use Illuminate\Foundation\Http\FormRequest;

class AwardUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('award')) ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1800', 'max:2100'],
            'description' => ['nullable', 'string'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:50'],
            'ceremony_date' => ['nullable', 'date'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Оновлена назва нагороди.',
                'example' => 'Букерівська премія',
            ],
            'year' => [
                'description' => 'Оновлений рік нагороди.',
                'example' => 2024,
            ],
            'description' => [
                'description' => 'Оновлений опис нагороди.',
                'example' => 'Престижна літературна премія за найкращий роман року.',
            ],
            'organizer' => [
                'description' => 'Оновлений організатор нагороди.',
                'example' => 'Booker Prize Foundation',
            ],
            'country' => [
                'description' => 'Оновлена країна нагороди.',
                'example' => 'United Kingdom',
            ],
            'ceremony_date' => [
                'description' => 'Оновлена дата церемонії.',
                'example' => '2024-11-15',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'award' => [
                'description' => 'UUID нагороди.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
