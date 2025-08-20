<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Report::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:type,description,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'reportable_type' => ['nullable', 'string', 'in:Post,Comment,Quote,Rating'],
            'reportable_id' => ['nullable', 'string'],
            'reason' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(\App\Enums\ReportStatus::values())],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для опису або причини звіту.',
                'example' => 'Порушення правил',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість звітів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (type, description, created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача, який подав звіт.',
                'example' => 'user-uuid123',
            ],
            'reportable_type' => [
                'description' => 'Фільтр за типом об’єкта звіту (Post, Comment, Quote, Rating).',
                'example' => 'Post',
            ],
            'reportable_id' => [
                'description' => 'Фільтр за ID об’єкта звіту.',
                'example' => 'post-uuid123',
            ],
            'reason' => [
                'description' => 'Фільтр за причиною звіту.',
                'example' => 'Непристойний вміст',
            ],
            'status' => [
                'description' => 'Фільтр за статусом звіту.',
                'example' => 'PENDING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
