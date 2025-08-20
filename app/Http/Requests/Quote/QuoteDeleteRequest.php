<?php

namespace App\Http\Requests\Quote;

use App\Models\Quote;
use Illuminate\Foundation\Http\FormRequest;

class QuoteDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        $quote = $this->route('quote');
        return $this->user()->can('delete', $quote);
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
            'quote' => [
                'description' => 'ID цитати для видалення.',
                'example' => 'quote-uuid123',
            ],
        ];
    }
}
