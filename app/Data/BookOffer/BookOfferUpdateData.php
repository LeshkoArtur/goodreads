<?php

namespace App\Data\BookOffer;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use Illuminate\Http\Request;

readonly class BookOfferUpdateData
{
    public function __construct(
        public ?string $book_id = null,
        public ?string $store_id = null,
        public ?float $price = null,
        public ?Currency $currency = null,
        public ?string $referral_url = null,
        public ?bool $availability = null,
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
            book_id: $data['book_id'] ?? null,
            store_id: $data['store_id'] ?? null,
            price: $data['price'] ?? null,
            currency: isset($data['currency']) ? Currency::from($data['currency']) : null,
            referral_url: $data['referral_url'] ?? null,
            availability: $data['availability'] ?? null,
            status: isset($data['status']) ? OfferStatus::from($data['status']) : null,
            last_updated_at: $data['last_updated_at'] ?? null,
        );
    }
}
