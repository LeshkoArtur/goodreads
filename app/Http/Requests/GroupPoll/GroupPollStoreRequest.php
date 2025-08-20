<?php

namespace App\Http\Requests\GroupPoll;

use App\Models\GroupPoll;
use Illuminate\Foundation\Http\FormRequest;

class GroupPollStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', GroupPoll::class);
    }

    public function rules(): array
    {
        return [
            'group_id' => ['required', 'string', 'exists:groups,id'],
            'creator_id' => ['required', 'string', 'exists:users,id'],
            'question' => ['required', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'group_id' => [
                'description' => 'ID групи, до якої відноситься опитування.',
                'example' => 'group-uuid123',
            ],
            'creator_id' => [
                'description' => 'ID користувача, який створює опитування.',
                'example' => 'user-uuid123',
            ],
            'question' => [
                'description' => 'Питання опитування.',
                'example' => 'Яка книга вам сподобалась найбільше?',
            ],
            'is_active' => [
                'description' => 'Чи є опитування активним.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
