<?php

namespace App\Data\BookOffer;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use Illuminate\Http\Request;

readonly class BookOfferIndexData
{
    public function __construct(
        public ?string $q = null,
        public ?string $book_id = null,
        public ?string $store_id = null,
        public ?float $min_price = null,
        public ?float $max_price = null,
        public ?Currency $currency = null,
        public ?OfferStatus $status = null,
        public ?bool $availability = null,
        public ?string $sort = null,
        public ?string $direction = null,
        public ?int $per_page = 15,
        public ?int $page = 1,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            q: $data['q'] ?? null,
            book_id: $data['book_id'] ?? null,
            store_id: $data['store_id'] ?? null,
            min_price: $data['min_price'] ?? null,
            max_price: $data['max_price'] ?? null,
            currency: isset($data['currency']) ? Currency::from($data['currency']) : null,
            status: isset($data['status']) ? OfferStatus::from($data['status']) : null,
            availability: $data['availability'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? null,
            per_page: $data['per_page'] ?? 15,
            page: $data['page'] ?? 1,
        );
    }
}
