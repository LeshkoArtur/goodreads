<?php

namespace App\Http\Requests\GroupEvent;

use App\Models\GroupEvent;
use Illuminate\Foundation\Http\FormRequest;

class GroupEventDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupEvent = $this->route('group_event');
        return $this->user()->can('delete', $groupEvent);
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
            'group_event' => [
                'description' => 'ID події групи для видалення.',
                'example' => 'event-uuid123',
            ],
        ];
    }
}
