<?php

namespace App\Http\Requests\BookSeries;

use Illuminate\Foundation\Http\FormRequest;

class BookSeriesUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $bookSeries = $this->route('book_series');

        return $this->user()?->can('update', $bookSeries) ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'is_completed' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва книжкової серії.',
                'example' => 'Володар перснів',
            ],
            'is_completed' => [
                'description' => 'Чи завершена серія.',
                'example' => true,
            ],
            'description' => [
                'description' => 'Опис книжкової серії.',
                'example' => 'Оновлений опис епічної фентезійної серії.',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'book_series' => [
                'description' => 'ID книжкової серії для оновлення.',
                'example' => 'series-uuid123',
            ],
        ];
    }
}
