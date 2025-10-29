<?php

namespace App\Http\Requests\AuthorQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AuthorQuestionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $authorQuestion = $this->route('author_question');

        return $this->user()?->can('update', $authorQuestion) ?? false;
    }

    public function rules(): array
    {
        return [
            'content' => ['nullable', 'string', 'max:5000'],
            'status' => ['nullable', new Enum(\App\Enums\QuestionStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'content' => [
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
