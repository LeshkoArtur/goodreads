<?php

namespace App\Http\Requests\EventRsvp;

use App\Models\EventRsvp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRsvpUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $eventRsvp = $this->route('event_rsvp');
        return $this->user()->can('update', $eventRsvp);
    }

    public function rules(): array
    {
        return [
            'response' => ['nullable', Rule::in(\App\Enums\EventResponse::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'response' => [
                'description' => 'Відповідь на подію.',
                'example' => 'GOING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'event_rsvp' => [
                'description' => 'ID RSVP на подію для оновлення.',
                'example' => 'rsvp-uuid123',
            ],
        ];
    }
}
