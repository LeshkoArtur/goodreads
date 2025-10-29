<?php

namespace App\Http\Requests\AuthorQuestion;

use Illuminate\Foundation\Http\FormRequest;

class AuthorQuestionDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $authorQuestion = $this->route('author_question');

        return $this->user()?->can('delete', $authorQuestion) ?? false;
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
            'author_question' => [
                'description' => 'ID питання до автора для видалення.',
                'example' => 'question-uuid123',
            ],
        ];
    }
}
