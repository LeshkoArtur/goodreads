<?php

namespace App\Http\Requests\NominationEntry;

use App\Models\NominationEntry;
use Illuminate\Foundation\Http\FormRequest;

class NominationEntryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', NominationEntry::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'nomination_id' => ['required', 'uuid', 'exists:nominations,id'],
            'book_id' => ['nullable', 'uuid', 'exists:books,id', 'required_without:author_id'],
            'author_id' => ['nullable', 'uuid', 'exists:authors,id', 'required_without:book_id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'nomination_id' => [
                'description' => 'UUID номінації.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'book_id' => [
                'description' => 'UUID книги (обов\'язкове якщо немає author_id).',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
            'author_id' => [
                'description' => 'UUID автора (обов\'язкове якщо немає book_id).',
                'example' => '7b5c6d1a-2c3d-4e5f-6a7b-8c9d0e1f2a3b',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
