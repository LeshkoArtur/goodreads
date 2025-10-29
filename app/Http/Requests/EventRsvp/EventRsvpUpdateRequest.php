<?php

namespace App\Http\Requests\EventRsvp;

use App\Enums\EventResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRsvpUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('eventRsvp')) ?? false;
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
                'description' => 'Оновлена відповідь на запрошення (going, maybe, not_going).',
                'example' => 'maybe',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'eventRsvp' => [
                'description' => 'UUID RSVP.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
