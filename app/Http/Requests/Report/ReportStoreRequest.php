<?php

namespace App\Http\Requests\Report;

use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Report::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'type' => ['required', Rule::in(\App\Enums\ReportType::values())],
            'reportable_id' => ['required', 'string'],
            'reportable_type' => ['required', 'string', 'in:Post,Comment,Quote,Rating'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(\App\Enums\ReportStatus::values())],
            // Ensure unique combination of user_id, reportable_id, and reportable_type
            'user_id' => ['unique:reports,user_id,NULL,id,reportable_id,' . $this->input('reportable_id') . ',reportable_type,' . $this->input('reportable_type')],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який подає звіт.',
                'example' => 'user-uuid123',
            ],
            'type' => [
                'description' => 'Тип звіту.',
                'example' => 'CONTENT_VIOLATION',
            ],
            'reportable_id' => [
                'description' => 'ID об’єкта, на який подано звіт.',
                'example' => 'post-uuid123',
            ],
            'reportable_type' => [
                'description' => 'Тип об’єкта звіту (Post, Comment, Quote, Rating).',
                'example' => 'Post',
            ],
            'description' => [
                'description' => 'Опис звіту.',
                'example' => 'Цей пост містить невідповідний вміст.',
            ],
            'status' => [
                'description' => 'Статус звіту.',
                'example' => 'PENDING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
