<?php

namespace App\Http\Requests\AuthorQuestion;

use App\Models\AuthorQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorQuestionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $authorQuestion = $this->route('author_question');
        return $this->user()->can('update', $authorQuestion);
    }

    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(\App\Enums\QuestionStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'body' => [
                'description' => 'Текст питання.',
                'example' => 'Оновлений текст питання...',
            ],
            'status' => [
                'description' => 'Статус питання.',
                'example' => 'APPROVED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'author_question' => [
                'description' => 'ID питання до автора для оновлення.',
                'example' => 'question-uuid123',
            ],
        ];
    }
}
