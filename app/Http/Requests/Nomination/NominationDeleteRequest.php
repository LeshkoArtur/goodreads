<?php

namespace App\Http\Requests\Nomination;

use App\Models\Nomination;
use Illuminate\Foundation\Http\FormRequest;

class NominationDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $nomination = $this->route('nomination');
        return $this->user()->can('delete', $nomination);
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
            'nomination' => [
                'description' => 'ID номінації для видалення.',
                'example' => 'nomination-uuid123',
            ],
        ];
    }
}
