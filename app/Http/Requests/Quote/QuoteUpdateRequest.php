<?php

namespace App\Http\Requests\Quote;

use Illuminate\Foundation\Http\FormRequest;

class QuoteUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $quote = $this->route('quote');

        return $this->user()?->can('update', $quote) ?? false;
    }

    public function rules(): array
    {
        return [
            'text' => ['nullable', 'string'],
            'page_number' => ['nullable', 'integer', 'min:1'],
            'contains_spoilers' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'text' => [
                'description' => 'Текст цитати.',
                'example' => 'Оновлена цитата з книги.',
            ],
            'page_number' => [
                'description' => 'Номер сторінки, де знаходиться цитата.',
                'example' => 42,
            ],
            'contains_spoilers' => [
                'description' => 'Чи містить цитата спойлери.',
                'example' => false,
            ],
            'is_public' => [
                'description' => 'Чи є цитата публічною.',
                'example' => true,
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'quote' => [
                'description' => 'ID цитати для оновлення.',
                'example' => 'quote-uuid123',
            ],
        ];
    }
}
