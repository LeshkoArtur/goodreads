<?php

namespace App\Data\Rating;

use Illuminate\Http\Request;

readonly class RatingUpdateData
{
    public function __construct(
        public ?string $user_id = null,
        public ?string $book_id = null,
        public ?int $rating = null,
        public ?string $review = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return self::fromArray($request->validated());
    }

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'] ?? null,
            book_id: $data['book_id'] ?? null,
            rating: $data['rating'] ?? null,
            review: $data['review'] ?? null,
        );
    }
}
