<?php

namespace App\Http\Requests\AuthorAnswer;

use App\Enums\AnswerStatus;
use App\Models\AuthorAnswer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AuthorAnswerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', AuthorAnswer::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'question_id' => ['required', 'string', 'exists:author_questions,id'],
            'author_id' => ['required', 'string', 'exists:authors,id'],
            'content' => ['required', 'string', 'max:10000'],
            'published_at' => ['nullable', 'date'],
            'status' => ['nullable', new Enum(AnswerStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'question_id' => [
                'description' => 'ID питання, на яке надається відповідь.',
                'example' => 'question-uuid123',
            ],
            'author_id' => [
                'description' => 'ID автора, який надає відповідь.',
                'example' => 'author-uuid123',
            ],
            'content' => [
                'description' => 'Текст відповіді.',
                'example' => 'Це моя відповідь на ваше питання...',
            ],
            'published_at' => [
                'description' => 'Дата публікації відповіді у форматі Y-m-d H:i:s.',
                'example' => '2023-01-01 12:00:00',
            ],
            'status' => [
                'description' => 'Статус відповіді.',
                'example' => 'PUBLISHED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
