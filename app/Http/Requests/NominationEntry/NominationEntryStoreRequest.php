<?php

namespace App\Http\Requests\NominationEntry;

use App\Models\NominationEntry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NominationEntryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', NominationEntry::class);
    }

    public function rules(): array
    {
        return [
            'nomination_id' => ['required', 'string', 'exists:nominations,id'],
            'book_id' => ['required', 'string', 'exists:books,id'],
            'author_id' => ['required', 'string', 'exists:authors,id'],
            'status' => ['nullable', Rule::in(\App\Enums\NominationStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'nomination_id' => [
                'description' => 'ID номінації, до якої відноситься запис.',
                'example' => 'nomination-uuid123',
            ],
            'book_id' => [
                'description' => 'ID книги, яка номінується.',
                'example' => 'book-uuid123',
            ],
            'author_id' => [
                'description' => 'ID автора книги.',
                'example' => 'author-uuid123',
            ],
            'status' => [
                'description' => 'Статус номінації.',
                'example' => 'PENDING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
