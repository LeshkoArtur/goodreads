<?php

namespace App\Data\BookOffer;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use Illuminate\Http\Request;

readonly class BookOfferStoreData
{
    public function __construct(
        public string $book_id,
        public string $store_id,
        public float $price,
        public Currency $currency,
        public string $referral_url,
        public ?bool $availability = true,
        public ?OfferStatus $status = null,
        public ?string $last_updated_at = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            book_id: $data['book_id'],
            store_id: $data['store_id'],
            price: $data['price'],
            currency: Currency::from($data['currency']),
            referral_url: $data['referral_url'],
            availability: $data['availability'] ?? true,
            status: isset($data['status']) ? OfferStatus::from($data['status']) : null,
            last_updated_at: $data['last_updated_at'] ?? null,
        );
    }
}
