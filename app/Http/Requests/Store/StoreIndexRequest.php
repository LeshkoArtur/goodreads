<?php

namespace App\Http\Requests\Store;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;

class StoreIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Store::class) ?? true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'query' => $this->input('q'),
        ]);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'region' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви магазину.',
                'example' => 'Книгарня',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість магазинів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, created_at).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'region' => [
                'description' => 'Фільтр за регіоном магазину.',
                'example' => 'Україна',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
