<?php

namespace App\Http\Requests\NominationEntry;

use App\Models\NominationEntry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NominationEntryIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', NominationEntry::class);
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'nomination_id' => ['nullable', 'string', 'exists:nominations,id'],
            'book_id' => ['nullable', 'string', 'exists:books,id'],
            'author_id' => ['nullable', 'string', 'exists:authors,id'],
            'status' => ['nullable', Rule::in(\App\Enums\NominationStatus::values())],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит для записів номінацій.',
                'example' => 'Номінація книги',
            ],
            'page' => [
                'description' => 'Номер сторінки для пагінації.',
                'example' => 1,
            ],
            'per_page' => [
                'description' => 'Кількість записів на сторінці.',
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
            'nomination_id' => [
                'description' => 'Фільтр за ID номінації.',
                'example' => 'nomination-uuid123',
            ],
            'book_id' => [
                'description' => 'Фільтр за ID книги.',
                'example' => 'book-uuid123',
            ],
            'author_id' => [
                'description' => 'Фільтр за ID автора.',
                'example' => 'author-uuid123',
            ],
            'status' => [
                'description' => 'Фільтр за статусом номінації.',
                'example' => 'PENDING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
