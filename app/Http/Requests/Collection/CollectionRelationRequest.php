<?php

namespace App\Http\Requests\Collection;

use Illuminate\Foundation\Http\FormRequest;

class CollectionRelationRequest extends FormRequest
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
                'example' => 'title',
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
            'collection' => [
                'description' => 'ID колекції.',
                'example' => 'collection-uuid123',
            ],
        ];
    }
}
