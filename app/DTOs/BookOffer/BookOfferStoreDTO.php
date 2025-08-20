<?php

namespace App\DTOs\BookOffer;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use Illuminate\Http\Request;

class BookOfferStoreDTO
{
    /**
     * @param string $bookId ID книги
     * @param string $storeId ID магазину
     * @param float $price Ціна з двома знаками після коми
     * @param Currency $currency Валюта
     * @param string|null $referralUrl Реферальне посилання
     * @param bool|null $availability Наявність товару
     * @param OfferStatus|null $status Статус пропозиції
     * @param string|null $lastUpdatedAt Дата останнього оновлення у форматі рядка
     */
    public function __construct(
        public readonly string $bookId,
        public readonly string $storeId,
        public readonly float $price,
        public readonly Currency $currency,
        public readonly ?string $referralUrl = null,
        public readonly ?bool $availability = null,
        public readonly ?OfferStatus $status = null,
        public readonly ?string $lastUpdatedAt = null,
    ) {}

    /**
     * Створити BookOfferStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            bookId: $request->input('book_id'),
            storeId: $request->input('store_id'),
            price: (float) $request->input('price'),
            currency: Currency::from($request->input('currency')),
            referralUrl: $request->input('referral_url'),
            availability: $request->has('availability') ? (bool) $request->input('availability') : null,
            status: $request->input('status') ? OfferStatus::from($request->input('status')) : null,
            lastUpdatedAt: $request->input('last_updated_at'),
        );
    }
}
