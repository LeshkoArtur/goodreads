<?php

namespace App\Http\Requests\NominationEntry;

use App\Enums\NominationStatus;
use App\Models\NominationEntry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NominationEntryIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', NominationEntry::class) ?? true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sort' => ['nullable', 'string', 'in:created_at,updated_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'nomination_id' => ['nullable', 'uuid', 'exists:nominations,id'],
            'book_id' => ['nullable', 'uuid', 'exists:books,id'],
            'author_id' => ['nullable', 'uuid', 'exists:authors,id'],
            'status' => ['nullable', Rule::enum(NominationStatus::class)],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'q' => [
                'description' => 'Пошуковий запит.',
                'example' => '',
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
                'description' => 'Фільтр за UUID номінації.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'book_id' => [
                'description' => 'Фільтр за UUID книги.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'author_id' => [
                'description' => 'Фільтр за UUID автора.',
                'example' => '7b5c6d1a-2c3d-4e5f-6a7b-8c9d0e1f2a3b',
            ],
            'status' => [
                'description' => 'Фільтр за статусом номінації.',
                'example' => 'approved',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
