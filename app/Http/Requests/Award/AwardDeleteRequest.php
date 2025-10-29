<?php

namespace App\Http\Requests\Award;

use Illuminate\Foundation\Http\FormRequest;

class AwardDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('delete', $this->route('award')) ?? false;
    }

    public function rules(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'award' => [
                'description' => 'UUID нагороди.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
