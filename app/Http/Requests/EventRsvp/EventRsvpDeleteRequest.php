<?php

namespace App\Http\Requests\EventRsvp;

use App\Models\EventRsvp;
use Illuminate\Foundation\Http\FormRequest;

class EventRsvpDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $eventRsvp = $this->route('event_rsvp');
        return $this->user()->can('delete', $eventRsvp);
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
            'event_rsvp' => [
                'description' => 'ID RSVP на подію для видалення.',
                'example' => 'rsvp-uuid123',
            ],
        ];
    }
}
