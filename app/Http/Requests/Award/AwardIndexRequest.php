<?php

namespace App\Http\Requests\Award;

use App\Models\Award;
use Illuminate\Foundation\Http\FormRequest;

class AwardIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Award::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,year,ceremony_date,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'year' => ['nullable', 'integer', 'min:1800', 'max:2100'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви, опису або організатора нагороди.',
                'example' => 'Букер',
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
                'description' => 'Поле для сортування (name, year, ceremony_date, created_at).',
                'example' => 'year',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'year' => [
                'description' => 'Фільтр за роком нагороди.',
                'example' => 2024,
            ],
            'organizer' => [
                'description' => 'Фільтр за організатором нагороди.',
                'example' => 'Booker Foundation',
            ],
            'country' => [
                'description' => 'Фільтр за країною.',
                'example' => 'United Kingdom',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
