<?php

namespace App\Http\Requests\Note;

use App\Models\Note;
use Illuminate\Foundation\Http\FormRequest;

class NoteDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $note = $this->route('note');
        return $this->user()->can('delete', $note);
    }

    public function rules(): array
    {
        return [];
    }

    public function bodyParameters(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'note' => [
                'description' => 'ID нотатки для видалення.',
                'example' => 'note-uuid123',
            ],
        ];
    }
}
