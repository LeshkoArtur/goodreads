<?php

namespace App\Http\Requests\GroupEvent;

use App\Enums\EventResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GroupEventRsvpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'response' => ['required', Rule::enum(EventResponse::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'response' => [
                'description' => 'Відповідь на запрошення (going, maybe, not_going).',
                'example' => 'going',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'groupEvent' => [
                'description' => 'UUID події групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
