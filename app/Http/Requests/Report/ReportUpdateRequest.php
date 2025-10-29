<?php

namespace App\Http\Requests\Report;

use App\Enums\ReportStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ReportUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $report = $this->route('report');

        return $this->user()?->can('update', $report) ?? false;
    }

    public function rules(): array
    {
        return [
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['nullable', new Enum(ReportStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'description' => [
                'description' => 'Опис звіту.',
                'example' => 'Оновлений опис звіту.',
            ],
            'status' => [
                'description' => 'Статус звіту.',
                'example' => 'RESOLVED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'report' => [
                'description' => 'ID звіту для оновлення.',
                'example' => 'report-uuid123',
            ],
        ];
    }
}
