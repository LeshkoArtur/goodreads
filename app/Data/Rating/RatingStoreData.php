<?php

namespace App\Data\Rating;

use Illuminate\Http\Request;

readonly class RatingStoreData
{
    public function __construct(
        public string $user_id,
        public string $book_id,
        public int $rating,
        public ?string $review = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            book_id: $data['book_id'],
            rating: $data['rating'],
            review: $data['review'] ?? null,
        );
    }
}
