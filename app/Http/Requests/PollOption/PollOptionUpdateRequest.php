<?php

namespace App\Http\Requests\PollOption;

use App\Models\PollOption;
use Illuminate\Foundation\Http\FormRequest;

class PollOptionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pollOption = $this->route('poll_option');
        return $this->user()->can('update', $pollOption);
    }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'title' => [
                'description' => 'Назва варіанту опитування.',
                'example' => 'Оновлений варіант 1',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'poll_option' => [
                'description' => 'ID варіанту опитування для оновлення.',
                'example' => 'option-uuid123',
            ],
        ];
    }
}
