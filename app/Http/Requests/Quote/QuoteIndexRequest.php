<?php

namespace App\Http\Requests\Quote;

use App\Models\Quote;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuoteIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Quote::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:text,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'string', 'exists:users,id'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'author_id' => ['nullable', 'string', 'exists:authors,id'],
            'status' => ['nullable', 'string', 'in:PENDING,APPROVED,REJECTED'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['string', 'exists:tags,id'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для тексту цитати.',
                'example' => 'Цитата з книги',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість цитат на сторінці.',
                'example' => 15,
            ],
            'sort' => [
                'description' => 'Поле для сортування (text, created_at).',
                'example' => 'created_at',
            ],
            'direction' => [
                'description' => 'Напрямок сортування (asc або desc).',
                'example' => 'desc',
            ],
            'user_id' => [
                'description' => 'Фільтр за ID користувача, який додав цитату.',
                'example' => 'user-uuid123',
            ],
            'book_id' => [
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'author_id' => [
                'description' => 'Фільтр за ID автора книги.',
                'example' => 'author-uuid123',
            ],
            'status' => [
                'description' => 'Фільтр за статусом цитати (PENDING, APPROVED, REJECTED).',
                'example' => 'APPROVED',
            ],
            'tag_ids' => [
                'description' => 'Фільтр за масивом ID тегів.',
                'example' => ['tag-uuid123', 'tag-uuid456'],
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
