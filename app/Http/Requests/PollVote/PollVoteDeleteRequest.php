<?php

namespace App\Http\Requests\PollVote;

use Illuminate\Foundation\Http\FormRequest;

class PollVoteDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('delete', $this->route('pollVote')) ?? false;
    }

    public function rules(): array
    {
        return [];
    }

    public function urlParameters(): array
    {
        return [
            'pollVote' => [
                'description' => 'UUID голосу.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }
}
