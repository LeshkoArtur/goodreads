<?php

namespace App\Http\Requests\PollOption;

use App\Models\PollOption;
use Illuminate\Foundation\Http\FormRequest;

class PollOptionDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pollOption = $this->route('poll_option');
        return $this->user()->can('delete', $pollOption);
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
            'poll_option' => [
                'description' => 'ID варіанту опитування для видалення.',
                'example' => 'option-uuid123',
            ],
        ];
    }
}
