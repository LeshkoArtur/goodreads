<?php

namespace App\Http\Requests\PollVote;

use App\Models\PollVote;
use Illuminate\Foundation\Http\FormRequest;

class PollVoteDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pollVote = $this->route('poll_vote');
        return $this->user()->can('delete', $pollVote);
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
            'poll_vote' => [
                'description' => 'ID голосу в опитуванні для видалення.',
                'example' => 'vote-uuid123',
            ],
        ];
    }
}
