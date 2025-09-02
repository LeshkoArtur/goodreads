<?php

namespace App\Http\Requests\BookOffer;

use App\Models\BookOffer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookOfferStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', BookOffer::class);
    }

    public function rules(): array
    {
        return [
            'book_id' => ['required', 'string', 'exists:books,id'],
            'store_id' => ['required', 'string', 'exists:stores,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', Rule::in(\App\Enums\Currency::values())],
            'referral_url' => ['nullable', 'url'],
            'availability' => ['nullable', 'boolean'],
            'status' => ['nullable', Rule::in(\App\Enums\OfferStatus::values())],
            'last_updated_at' => ['nullable', 'date'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'book_id' => [
                'description' => 'ID книги, до якої відноситься пропозиція.',
                'example' => 'book-uuid123',
            ],
            'store_id' => [
                'description' => 'ID магазину, який пропонує книгу.',
                'example' => 'store-uuid123',
            ],
            'price' => [
                'description' => 'Ціна пропозиції з двома знаками після коми.',
                'example' => 29.99,
            ],
            'currency' => [
                'description' => 'Валюта пропозиції.',
                'example' => 'USD',
            ],
            'referral_url' => [
                'description' => 'Реферальне посилання на пропозицію.',
                'example' => 'https://store.com/book-offer',
            ],
            'availability' => [
                'description' => 'Наявність книги в магазині.',
                'example' => true,
            ],
            'status' => [
                'description' => 'Статус пропозиції.',
                'example' => 'ACTIVE',
            ],
            'last_updated_at' => [
                'description' => 'Дата останнього оновлення пропозиції у форматі Y-m-d H:i:s.',
                'example' => '2023-01-01 12:00:00',
            ],
        ];
    }

    public function urlParameters(): array
    {
        return [];
    }
}
