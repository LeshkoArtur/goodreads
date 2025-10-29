<?php

namespace App\Http\Requests\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class TagIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Tag::class) ?? true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'query' => $this->input('q'),
            'min_taggable_count' => $this->input('min_usage_count'),
            'max_taggable_count' => $this->input('max_usage_count'),
        ]);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:50'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at,taggable_count'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'min_usage_count' => ['nullable', 'integer', 'min:0'],
            'max_usage_count' => ['nullable', 'integer', 'min:0', 'gte:min_usage_count'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для назви тегу.',
                'example' => 'Фантастика',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість тегів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (name, created_at, taggable_count).',
                'example' => 'name',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'asc',
            ],
            'min_usage_count' => [
                'description' => 'Мінімальна кількість використань тегу.',
                'example' => 0,
            ],
            'max_usage_count' => [
                'description' => 'Максимальна кількість використань тегу.',
                'example' => 100,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
