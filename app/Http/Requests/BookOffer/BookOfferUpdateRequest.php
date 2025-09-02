<?php

namespace App\Http\Requests\BookOffer;

use App\Models\BookOffer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookOfferUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $bookOffer = $this->route('book_offer');
        return $this->user()->can('update', $bookOffer);
    }

    public function rules(): array
    {
        return [
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', Rule::in(\App\Enums\Currency::values())],
            'status' => ['nullable', Rule::in(\App\Enums\OfferStatus::values())],
            'url' => ['nullable', 'url'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'price' => [
                'description' => 'Ціна пропозиції з двома знаками після коми.',
                'example' => 29.99,
            ],
            'currency' => [
                'description' => 'Валюта пропозиції.',
                'example' => 'USD',
            ],
            'status' => [
                'description' => 'Статус пропозиції.',
                'example' => 'ACTIVE',
            ],
            'url' => [
                'description' => 'URL пропозиції.',
                'example' => 'https://store.com/book-offer',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [
            'book_offer' => [
                'description' => 'ID пропозиції книги для оновлення.',
                'example' => 'offer-uuid123',
            ],
        ];
    }
}
