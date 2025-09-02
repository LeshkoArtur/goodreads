<?php

namespace App\DTOs\BookOffer;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use Illuminate\Http\Request;

/**
 * DTO для оновлення даних пропозиції книги.
 */
class BookOfferUpdateDTO
{
    /**
     * Створює новий екземпляр BookOfferUpdateDTO.
     *
     * @param float|null $price Ціна пропозиції
     * @param string|null $currency Валюта пропозиції
     * @param string|null $status Статус пропозиції
     * @param string|null $url URL пропозиції
     */
    public function __construct(
        public readonly ?float $price = null,
        public readonly ?string $currency = null,
        public readonly ?string $status = null,
        public readonly ?string $url = null,
    ) {
    }

    /**
     * Створює новий екземпляр DTO з запиту.
     *
     * @param Request $request HTTP-запит
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            price: $request->input('price') ? (float) $request->input('price') : null,
            currency: $request->input('currency'),
            status: $request->input('status'),
            url: $request->input('url'),
        );
    }
}
