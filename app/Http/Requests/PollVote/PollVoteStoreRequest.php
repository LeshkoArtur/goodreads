<?php

namespace App\Http\Requests\PollVote;

use App\Models\PollVote;
use Illuminate\Foundation\Http\FormRequest;

class PollVoteStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', PollVote::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'group_poll_id' => ['required', 'uuid', 'exists:group_polls,id'],
            'poll_option_id' => ['required', 'uuid', 'exists:poll_options,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_poll_id' => [
                'description' => 'UUID опитування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
            'poll_option_id' => [
                'description' => 'UUID варіанта відповіді для голосування.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
