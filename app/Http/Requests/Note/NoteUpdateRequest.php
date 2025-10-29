<?php

namespace App\Http\Requests\Note;

use Illuminate\Foundation\Http\FormRequest;

class NoteUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $note = $this->route('note');

        return $this->user()?->can('update', $note) ?? false;
    }

    public function rules(): array
    {
        return [
            'text' => ['nullable', 'string'],
            'contains_spoilers' => ['nullable', 'boolean'],
            'is_private' => ['nullable', 'boolean'],
            'page_number' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'text' => [
                'description' => 'Текст нотатки.',
                'example' => 'Оновлена нотатка зі сторінки 42.',
            ],
            'contains_spoilers' => [
                'description' => 'Чи містить нотатка спойлери.',
                'example' => true,
            ],
            'is_private' => [
                'description' => 'Чи є нотатка приватною.',
                'example' => true,
            ],
            'page_number' => [
                'description' => 'Номер сторінки, до якої відноситься нотатка.',
                'example' => 42,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'note' => [
                'description' => 'ID нотатки для оновлення.',
                'example' => 'note-uuid123',
            ],
        ];
    }
}
