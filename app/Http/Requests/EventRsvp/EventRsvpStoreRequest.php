<?php

namespace App\Http\Requests\EventRsvp;

use App\Enums\EventResponse;
use App\Models\EventRsvp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRsvpStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', EventRsvp::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'group_event_id' => ['required', 'uuid', 'exists:group_events,id'],
            'response' => ['required', Rule::enum(EventResponse::class)],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_event_id' => [
                'description' => 'UUID події групи.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'response' => [
                'description' => 'Відповідь на запрошення (going, maybe, not_going).',
                'example' => 'going',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
