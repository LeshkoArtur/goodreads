<?php

namespace App\Http\Requests\PollVote;

use App\Models\PollVote;
use Illuminate\Foundation\Http\FormRequest;

class PollVoteUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pollVote = $this->route('poll_vote');
        return $this->user()->can('update', $pollVote);
    }

    public function rules(): array
    {
        return [
            'poll_option_id' => ['nullable', 'string', 'exists:poll_options,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'poll_option_id' => [
                'description' => 'ID варіанту опитування, за який проголосовано.',
                'example' => 'option-uuid123',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'poll_vote' => [
                'description' => 'ID голосу в опитуванні для оновлення.',
                'example' => 'vote-uuid123',
            ],
        ];
    }
}
