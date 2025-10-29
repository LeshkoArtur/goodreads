<?php

namespace App\Http\Requests\BookSeries;

use Illuminate\Foundation\Http\FormRequest;

class BookSeriesDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $bookSeries = $this->route('book_series');

        return $this->user()?->can('delete', $bookSeries) ?? false;
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'book_series' => [
                'description' => 'ID книжкової серії для видалення.',
                'example' => 'series-uuid123',
            ],
        ];
    }
}
