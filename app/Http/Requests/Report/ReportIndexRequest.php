<?php

namespace App\Http\Requests\Report;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ReportIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Report::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'type' => ['nullable', new Enum(ReportType::class)],
            'reportable_type' => ['nullable', 'string'],
            'reportable_id' => ['nullable', 'uuid'],
            'status' => ['nullable', new Enum(ReportStatus::class)],
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
                'description' => 'Кількість звітів на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at).',
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
                'description' => 'Фільтр за типом об’єкта звіту. Можливі значення: App\\Models\\Post, App\\Models\\Comment, App\\Models\\GroupPost, App\\Models\\Quote, App\\Models\\Rating.',
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
                'description' => 'Фільтр за статусом звіту. Можливі значення: pending, reviewed, resolved, dismissed.',
                'example' => 'pending',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
