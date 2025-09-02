<?php

namespace App\Http\Requests\Quote;

use App\Models\Quote;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuoteUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $quote = $this->route('quote');
        return $this->user()->can('update', $quote);
    }

    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:PENDING,APPROVED,REJECTED'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['string', 'exists:tags,id'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'body' => [
                'description' => 'Текст цитати.',
                'example' => 'Оновлена цитата з книги.',
            ],
            'status' => [
                'description' => 'Статус цитати (PENDING, APPROVED, REJECTED).',
                'example' => 'APPROVED',
            ],
            'tag_ids' => [
                'description' => 'Масив ID тегів, пов’язаних з цитатою.',
                'example' => ['tag-uuid123', 'tag-uuid456'],
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
