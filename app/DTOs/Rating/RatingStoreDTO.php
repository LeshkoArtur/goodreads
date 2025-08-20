<?php

namespace App\DTOs\Rating;

use Illuminate\Http\Request;

class RatingStoreDTO
{
    /**
     * @param string $userId ID користувача
     * @param string $bookId ID книги
     * @param int $rating Оцінка
     * @param string|null $review Відгук
     */
    public function __construct(
        public readonly string $userId,
        public readonly string $bookId,
        public readonly int $rating,
        public readonly ?string $review = null
    ) {}

    /**
     * Створити RatingStoreDTO з HTTP-запиту
     *
     * @param Request $request
     * @return static
     */
    public static function fromRequest(Request $request): static
    {
        return new static(
            userId: $request->input('user_id'),
            bookId: $request->input('book_id'),
            rating: $request->input('rating'),
            review: $request->input('review')
        );
    }
}
