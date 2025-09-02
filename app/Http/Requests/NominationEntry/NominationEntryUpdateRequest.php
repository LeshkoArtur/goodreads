<?php

namespace App\Http\Requests\NominationEntry;

use App\Models\NominationEntry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NominationEntryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $nominationEntry = $this->route('nomination_entry');
        return $this->user()->can('update', $nominationEntry);
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', Rule::in(\App\Enums\NominationStatus::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'status' => [
                'description' => 'Статус номінації.',
                'example' => 'APPROVED',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'nomination_entry' => [
                'description' => 'ID запису номінації для оновлення.',
                'example' => 'entry-uuid123',
            ],
        ];
    }
}
