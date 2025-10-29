<?php

namespace App\Http\Requests\NominationEntry;

use App\Enums\NominationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NominationEntryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('nominationEntry')) ?? false;
    }

    public function rules(): array
    {
        return [
            'book_id' => ['nullable', 'uuid', 'exists:books,id'],
            'author_id' => ['nullable', 'uuid', 'exists:authors,id'],
            'status' => ['nullable', Rule::enum(NominationStatus::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'book_id' => [
                'description' => 'Оновлений UUID книги.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'author_id' => [
                'description' => 'Оновлений UUID автора.',
                'example' => '7b5c6d1a-2c3d-4e5f-6a7b-8c9d0e1f2a3b',
            ],
            'status' => [
                'description' => 'Оновлений статус номінації.',
                'example' => 'approved',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'nominationEntry' => [
                'description' => 'UUID запису номінації.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
