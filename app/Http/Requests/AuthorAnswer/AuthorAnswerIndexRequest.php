<?php

namespace App\Http\Requests\AuthorAnswer;

use App\Enums\AnswerStatus;
use App\Models\AuthorAnswer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorAnswerIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', AuthorAnswer::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at,published_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'question_id' => ['nullable', 'string', 'exists:author_questions,id'],
            'author_id' => ['nullable', 'string', 'exists:authors,id'],
            'status' => ['nullable', Rule::in(AnswerStatus::values())],
            'min_published_at' => ['nullable', 'date'],
            'max_published_at' => ['nullable', 'date'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для тексту відповіді.',
                'example' => 'Відповідь на питання',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість відповідей на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at, published_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'question_id' => [
                'description' => 'Фільтр за ID питання.',
                'example' => 'question-uuid123',
            ],
            'author_id' => [
                'description' => 'Фільтр за ID автора.',
                'example' => 'author-uuid123',
            ],
            'status' => [
                'description' => 'Фільтр за статусом відповіді.',
                'example' => 'PUBLISHED',
            ],
            'min_published_at' => [
                'description' => 'Мінімальна дата публікації для фільтрації.',
                'example' => '2023-01-01 00:00:00',
            ],
            'max_published_at' => [
                'description' => 'Максимальна дата публікації для фільтрації.',
                'example' => '2023-12-31 23:59:59',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
