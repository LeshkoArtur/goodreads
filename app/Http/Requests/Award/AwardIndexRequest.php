<?php

namespace App\Http\Requests\Award;

use App\Models\Award;
use Illuminate\Foundation\Http\FormRequest;

class AwardIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Award::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,year,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'year' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'organizer' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'min_ceremony_date' => ['nullable', 'date'],
            'max_ceremony_date' => ['nullable', 'date'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви або опису нагороди.',
                'example' => 'Літературна премія',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість нагород на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, year, created_at).',
                'example' => 'year',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'year' => [
                'description' => 'Фільтр за роком нагороди.',
                'example' => 2023,
            ],
            'organizer' => [
                'description' => 'Фільтр за організатором нагороди.',
                'example' => 'Академія літератури',
            ],
            'country' => [
                'description' => 'Фільтр за країною нагороди.',
                'example' => 'Україна',
            ],
            'min_ceremony_date' => [
                'description' => 'Мінімальна дата церемонії для фільтрації.',
                'example' => '2023-01-01',
            ],
            'max_ceremony_date' => [
                'description' => 'Максимальна дата церемонії для фільтрації.',
                'example' => '2023-12-31',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
