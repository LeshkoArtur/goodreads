<?php

namespace App\Http\Requests\Award;

use App\Models\Award;
use Illuminate\Foundation\Http\FormRequest;

class AwardStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Award::class) ?? false;
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
                'description' => 'Назва нагороди.',
                'example' => 'Букерівська премія',
            ],
            'year' => [
                'description' => 'Рік нагороди.',
                'example' => 2024,
            ],
            'description' => [
                'description' => 'Опис нагороди.',
                'example' => 'Престижна літературна премія за найкращий роман року.',
            ],
            'organizer' => [
                'description' => 'Організатор нагороди.',
                'example' => 'Booker Prize Foundation',
            ],
            'country' => [
                'description' => 'Країна нагороди.',
                'example' => 'United Kingdom',
            ],
            'ceremony_date' => [
                'description' => 'Дата церемонії нагородження.',
                'example' => '2024-11-15',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
