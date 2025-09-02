<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class RatingQueryBuilder extends Builder
{
    /**
     * Оцінки від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Оцінки для певної книги.
     */
    public function forBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Оцінки з мінімальним значенням.
     */
    public function minRating(int $rating): static
    {
        return $this->where('rating', '>=', $rating);
    }

    /**
     * Оцінки з відгуками.
     */
    public function withReview(): static
    {
        return $this->whereNotNull('review');
    }

    /**
     * Оцінки з коментарями.
     */
    public function withComments(): static
    {
        return $this->has('comments');
    }
}
