<?php

namespace App\Http\Requests\NominationEntry;

use App\Models\NominationEntry;
use Illuminate\Foundation\Http\FormRequest;

class NominationEntryDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $nominationEntry = $this->route('nomination_entry');
        return $this->user()->can('delete', $nominationEntry);
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
            'nomination_entry' => [
                'description' => 'ID запису номінації для видалення.',
                'example' => 'entry-uuid123',
            ],
        ];
    }
}
