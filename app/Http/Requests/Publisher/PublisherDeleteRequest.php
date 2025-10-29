<?php

namespace App\Http\Requests\Publisher;

use Illuminate\Foundation\Http\FormRequest;

class PublisherDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $publisher = $this->route('publisher');

        return $this->user()?->can('delete', $publisher) ?? false;
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
            'publisher' => [
                'description' => 'ID видавця для видалення.',
                'example' => 'publisher-uuid123',
            ],
        ];
    }
}
