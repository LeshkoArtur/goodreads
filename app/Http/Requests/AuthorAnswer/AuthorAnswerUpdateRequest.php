<?php

namespace App\Http\Requests\AuthorAnswer;

use App\Enums\AnswerStatus;
use App\Models\AuthorAnswer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorAnswerUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $authorAnswer = $this->route('author_answer');
        return $this->user()->can('update', $authorAnswer);
    }

    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'status' => ['nullable', Rule::in(AnswerStatus::values())],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'body' => [
                'description' => 'Текст відповіді.',
                'example' => 'Оновлений текст відповіді...',
            ],
            'status' => [
                'description' => 'Статус відповіді.',
                'example' => 'PUBLISHED',
            ],
            'published_at' => [
                'description' => 'Дата публікації відповіді у форматі Y-m-d H:i:s.',
                'example' => '2023-01-01 12:00:00',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'author_answer' => [
                'description' => 'ID відповіді автора для оновлення.',
                'example' => 'answer-uuid123',
            ],
        ];
    }
}
