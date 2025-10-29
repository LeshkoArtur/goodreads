<?php

namespace App\Http\Requests\Report;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Report;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ReportStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Report::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'string',
                'exists:users,id',
                'unique:reports,user_id,NULL,id,reportable_id,'.$this->input('reportable_id').',reportable_type,'.$this->input('reportable_type')
            ],
            'type' => ['required', new Enum(ReportType::class)],
            'reportable_id' => ['required', 'uuid'],
            'reportable_type' => ['required', 'string', 'in:App\\Models\\Post,App\\Models\\Comment,App\\Models\\GroupPost,App\\Models\\Quote,App\\Models\\Rating'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['nullable', new Enum(ReportStatus::class)],
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
                'description' => 'Тип звіту. Можливі значення: spam, offensive, inappropriate, spoilers, copyright, other.',
                'example' => 'spam',
            ],
            'reportable_id' => [
                'description' => 'ID об’єкта, на який подано звіт.',
                'example' => 'post-uuid123',
            ],
            'reportable_type' => [
                'description' => 'Тип об’єкта звіту. Можливі значення: App\\Models\\Post, App\\Models\\Comment, App\\Models\\GroupPost, App\\Models\\Quote, App\\Models\\Rating.',
                'example' => 'App\\Models\\Post',
            ],
            'description' => [
                'description' => 'Опис звіту.',
                'example' => 'Цей пост містить невідповідний вміст.',
            ],
            'status' => [
                'description' => 'Статус звіту. Можливі значення: pending, reviewed, resolved, dismissed.',
                'example' => 'pending',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
