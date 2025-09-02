<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;

class ReportDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $report = $this->route('report');
        return $this->user()->can('delete', $report);
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'report' => [
                'description' => 'ID звіту для видалення.',
                'example' => 'report-uuid123',
            ],
        ];
    }
}
