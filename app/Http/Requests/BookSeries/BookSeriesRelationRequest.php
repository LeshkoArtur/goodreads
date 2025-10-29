<?php

namespace App\Http\Requests\BookSeries;

use Illuminate\Foundation\Http\FormRequest;

class BookSeriesRelationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість записів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування.',
                'example' => 'number_in_series',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'bookSeries' => [
                'description' => 'ID серії книг.',
                'example' => 'book-series-uuid123',
            ],
        ];
    }
}
