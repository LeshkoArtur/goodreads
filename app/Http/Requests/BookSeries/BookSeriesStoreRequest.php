<?php

namespace App\Http\Requests\BookSeries;

use App\Models\BookSeries;
use Illuminate\Foundation\Http\FormRequest;

class BookSeriesStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', BookSeries::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'total_books' => ['nullable', 'integer', 'min:1'],
            'is_completed' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва книжкової серії.',
                'example' => 'Володар перснів',
            ],
            'description' => [
                'description' => 'Опис книжкової серії.',
                'example' => 'Епічна фентезійна серія про пригоди у Середзем’ї.',
            ],
            'total_books' => [
                'description' => 'Загальна кількість книг у серії.',
                'example' => 3,
            ],
            'is_completed' => [
                'description' => 'Чи завершена серія.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
