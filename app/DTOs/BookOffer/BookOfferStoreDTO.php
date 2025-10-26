<?php

namespace App\DTOs\BookOffer;

use App\DTOs\Traits\HandlesJsonArrays;
use App\Enums\Currency;
use App\Enums\OfferStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookOfferStoreDTO
{
    use HandlesJsonArrays;

    public function __construct(
        public readonly string $bookId,
        public readonly string $storeId,
        public readonly float $price,
        public readonly Currency $currency,
        public readonly ?string $referralUrl = null,
        public readonly ?bool $availability = null,
        public readonly ?OfferStatus $status = null,
        public readonly ?string $lastUpdatedAt = null,
        public readonly array|Collection|null $mediaImages = null,
        public readonly array|Collection|null $socialMediaLinks = null
    ) {}

    public static function fromRequest(Request $request): static
    {
        return self::makeDTO($request->all());
    }

    public static function fromArray(array $data): static
    {
        return self::makeDTO($data);
    }

    private static function makeDTO(array $data): static
    {
        return new static(
            bookId: $data['book_id'],
            storeId: $data['store_id'],
            price: (float) $data['price'],
            currency: Currency::from($data['currency']),
            referralUrl: $data['referral_url'] ?? null,
            availability: isset($data['availability']) ? (bool) $data['availability'] : null,
            status: !empty($data['status']) ? OfferStatus::from($data['status']) : null,
            lastUpdatedAt: $data['last_updated_at'] ?? null,
            mediaImages: self::processJsonArray($data['media_images'] ?? null),
            socialMediaLinks: self::processJsonArray($data['social_media_links'] ?? null)
        );
    }
}
