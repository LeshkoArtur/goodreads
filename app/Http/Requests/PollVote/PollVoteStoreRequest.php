<?php

namespace App\Http\Requests\PollVote;

use App\Models\PollVote;
use Illuminate\Foundation\Http\FormRequest;

class PollVoteStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', PollVote::class);
    }

    public function rules(): array
    {
        return [
            'group_poll_id' => ['required', 'string', 'exists:group_polls,id'],
            'poll_option_id' => ['required', 'string', 'exists:poll_options,id'],
            'user_id' => ['required', 'string', 'exists:users,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_poll_id' => [
                'description' => 'ID опитування, до якого відноситься голос.',
                'example' => 'poll-uuid123',
            ],
            'poll_option_id' => [
                'description' => 'ID варіанту опитування, за який проголосовано.',
                'example' => 'option-uuid123',
            ],
            'user_id' => [
                'description' => 'ID користувача, який проголосував.',
                'example' => 'user-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
