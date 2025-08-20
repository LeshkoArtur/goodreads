<?php

namespace App\Http\Requests\GroupPoll;

use App\Models\GroupPoll;
use Illuminate\Foundation\Http\FormRequest;

class GroupPollDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupPoll = $this->route('group_poll');
        return $this->user()->can('delete', $groupPoll);
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
            'group_poll' => [
                'description' => 'ID опитування для видалення.',
                'example' => 'poll-uuid123',
            ],
        ];
    }
}
