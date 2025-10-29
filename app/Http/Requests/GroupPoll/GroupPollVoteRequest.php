<?php

namespace App\Http\Requests\GroupPoll;

use Illuminate\Foundation\Http\FormRequest;

class GroupPollVoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'poll_option_id' => ['required', 'uuid', 'exists:poll_options,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'poll_option_id' => [
                'description' => 'UUID варіанта відповіді для голосування.',
                'example' => '9d7e8f1a-3b2c-4d5e-9f1a-2b3c4d5e6f7a',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'groupPoll' => [
                'description' => 'UUID опитування групи.',
                'example' => '8c6d7e2b-1a9c-3d4e-8f2b-1c2d3e4f5a6b',
            ],
        ];
    }
}
