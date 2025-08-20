<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $report = $this->route('report');
        return $this->user()->can('update', $report);
    }

    public function rules(): array
    {
        return [
            'reason' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(\App\Enums\ReportStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'reason' => [
                'description' => 'Причина звіту.',
                'example' => 'Непристойний вміст',
            ],
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
