<?php

namespace App\Http\Requests\AuthorAnswer;

use Illuminate\Foundation\Http\FormRequest;

class AuthorAnswerDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $authorAnswer = $this->route('author_answer');
        return $this->user()->can('delete', $authorAnswer);
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
            'author_answer' => [
                'description' => 'ID відповіді автора для видалення.',
                'example' => 'answer-uuid123',
            ],
        ];
    }
}
