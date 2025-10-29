<?php

namespace App\Http\Requests\AuthorQuestion;

use App\Enums\QuestionStatus;
use App\Models\AuthorQuestion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class AuthorQuestionIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', AuthorQuestion::class) ?? true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'query' => $this->input('q'),
        ]);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'author_id' => ['nullable', 'string', 'exists:authors,id'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'status' => ['nullable', new Enum(QuestionStatus::class)],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для тексту питання.',
                'example' => 'Питання про книгу',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість питань на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача.',
                'example' => 'user-uuid123',
            ],
            'author_id' => [
                'description' => 'Фільтр за ID автора.',
                'example' => 'author-uuid123',
            ],
            'book_id' => [
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'status' => [
                'description' => 'Фільтр за статусом питання.',
                'example' => 'PENDING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
