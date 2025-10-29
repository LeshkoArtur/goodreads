<?php

namespace App\Http\Requests\AuthorQuestion;

use App\Enums\QuestionStatus;
use App\Models\AuthorQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AuthorQuestionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', AuthorQuestion::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'author_id' => ['required', 'string', 'exists:authors,id'],
            'content' => ['required', 'string', 'max:5000'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'status' => ['nullable', new Enum(QuestionStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'user_id' => [
                'description' => 'ID користувача, який задає питання.',
                'example' => 'user-uuid123',
            ],
            'author_id' => [
                'description' => 'ID автора, до якого адресоване питання.',
                'example' => 'author-uuid123',
            ],
            'content' => [
                'description' => 'Текст питання.',
                'example' => 'Яка була ваша мотивація для написання цієї книги?',
            ],
            'book_id' => [
                'description' => 'ID книги, пов’язаної з питанням (опційно).',
                'example' => 'book-uuid123',
            ],
            'status' => [
                'description' => 'Статус питання.',
                'example' => 'PENDING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
