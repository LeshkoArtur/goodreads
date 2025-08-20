<?php

namespace App\Http\Requests\EventRsvp;

use App\Models\EventRsvp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRsvpStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', EventRsvp::class);
    }

    public function rules(): array
    {
        return [
            'group_event_id' => ['required', 'string', 'exists:group_events,id'],
            'user_id' => ['required', 'string', 'exists:users,id'],
            'response' => ['required', Rule::in(\App\Enums\EventResponse::values())],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_event_id' => [
                'description' => 'ID події групи.',
                'example' => 'event-uuid123',
            ],
            'user_id' => [
                'description' => 'ID користувача, який відповідає на подію.',
                'example' => 'user-uuid123',
            ],
            'response' => [
                'description' => 'Відповідь на подію.',
                'example' => 'GOING',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
