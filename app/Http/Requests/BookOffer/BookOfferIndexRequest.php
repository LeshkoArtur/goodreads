<?php

namespace App\Http\Requests\BookOffer;

use App\Models\BookOffer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookOfferIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', BookOffer::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:price,created_at,last_updated_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'store_id' => ['nullable', 'string', 'exists:stores,id'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', Rule::in(\App\Enums\Currency::values())],
            'status' => ['nullable', Rule::in(\App\Enums\OfferStatus::values())],
            'min_last_updated_at' => ['nullable', 'date'],
            'max_last_updated_at' => ['nullable', 'date'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для пропозицій книг.',
                'example' => 'Книга в наявності',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість пропозицій на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (price, created_at, last_updated_at).',
                'example' => 'price',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'book_id' => [
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'store_id' => [
                'description' => 'Фільтр за ID магазину.',
                'example' => 'store-uuid123',
            ],
            'min_price' => [
                'description' => 'Мінімальна ціна для фільтрації.',
                'example' => 10.99,
            ],
            'max_price' => [
                'description' => 'Максимальна ціна для фільтрації.',
                'example' => 50.00,
            ],
            'currency' => [
                'description' => 'Фільтр за валютою.',
                'example' => 'USD',
            ],
            'status' => [
                'description' => 'Фільтр за статусом пропозиції.',
                'example' => 'ACTIVE',
            ],
            'min_last_updated_at' => [
                'description' => 'Мінімальний час останнього оновлення для фільтрації.',
                'example' => '2023-01-01 00:00:00',
            ],
            'max_last_updated_at' => [
                'description' => 'Максимальний час останнього оновлення для фільтрації.',
                'example' => '2023-12-31 23:59:59',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
