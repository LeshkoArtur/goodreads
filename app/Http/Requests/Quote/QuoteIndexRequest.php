<?php

namespace App\Http\Requests\Quote;

use App\Models\Quote;
use Illuminate\Foundation\Http\FormRequest;

class QuoteIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Quote::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:text,created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'user_id' => ['nullable', 'uuid', 'exists:users,id'],
            'book_id' => ['nullable', 'uuid', 'exists:books,id'],
            'contains_spoilers' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
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
            'contains_spoilers' => [
                'description' => 'Фільтр за наявністю спойлерів.',
                'example' => false,
            ],
            'is_public' => [
                'description' => 'Фільтр за публічністю цитати.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
