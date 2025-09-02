<?php

namespace App\Http\Requests\Publisher;

use App\Models\Publisher;
use Illuminate\Foundation\Http\FormRequest;

class PublisherIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Publisher::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,founded_year,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'country' => ['nullable', 'string', 'max:100'],
            'min_founded_year' => ['nullable', 'integer', 'min:0'],
            'max_founded_year' => ['nullable', 'integer', 'min:0', 'gte:min_founded_year'],
            'contact_emails' => ['nullable', 'array'],
            'contact_emails.*' => ['email'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису видавця.',
                'example' => 'Видавництво',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість видавців на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, founded_year, created_at).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'country' => [
                'description' => 'Фільтр за країною видавця.',
                'example' => 'Україна',
            ],
            'min_founded_year' => [
                'description' => 'Мінімальний рік заснування для фільтрації.',
                'example' => 1900,
            ],
            'max_founded_year' => [
                'description' => 'Максимальний рік заснування для фільтрації.',
                'example' => 2023,
            ],
            'contact_emails' => [
                'description' => 'Фільтр за контактними email видавця.',
                'example' => ['contact1@example.com', 'contact2@example.com'],
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
