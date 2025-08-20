<?php

namespace App\Http\Requests\Store;

use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;

class StoreIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Store::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,region,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'country' => ['nullable', 'string', 'max:100'],
            'type' => ['nullable', 'string', 'in:BOOKSTORE,LIBRARY,MARKETPLACE'],
            'is_online' => ['nullable', 'boolean'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або регіону магазину.',
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
                'description' => 'Поле для сортування (name, region, created_at).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'country' => [
                'description' => 'Фільтр за країною магазину.',
                'example' => 'Україна',
            ],
            'type' => [
                'description' => 'Фільтр за типом магазину (BOOKSTORE, LIBRARY, MARKETPLACE).',
                'example' => 'BOOKSTORE',
            ],
            'is_online' => [
                'description' => 'Фільтр за онлайн/офлайн статусом магазину.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
