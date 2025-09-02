<?php

namespace App\Http\Requests\GroupPoll;

use App\Models\GroupPoll;
use Illuminate\Foundation\Http\FormRequest;

class GroupPollUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $groupPoll = $this->route('group_poll');
        return $this->user()->can('update', $groupPoll);
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва опитування.',
                'example' => 'Найкраща книга місяця',
            ],
            'description' => [
                'description' => 'Опис опитування.',
                'example' => 'Виберіть книгу, яка вам сподобалась найбільше.',
            ],
            'is_active' => [
                'description' => 'Чи є опитування активним.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'group_poll' => [
                'description' => 'ID опитування для оновлення.',
                'example' => 'poll-uuid123',
            ],
        ];
    }
}
