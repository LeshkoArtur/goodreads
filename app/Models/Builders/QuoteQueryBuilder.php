<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class QuoteQueryBuilder extends Builder
{
    /**
     * Цитати від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Цитати з певної книги.
     */
    public function forBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Цитати, що містять спойлери.
     */
    public function withSpoilers(): static
    {
        return $this->where('contains_spoilers', true);
    }

    /**
     * Публічні цитати.
     */
    public function isPublic(): static
    {
        return $this->where('is_public', true);
    }

    /**
     * Цитати з певним текстом (частковий збіг).
     */
    public function withText(string $text): static
    {
        return $this->where('text', 'like', '%'.$text.'%');
    }

    /**
     * Цитати з коментарями.
     */
    public function withComments(): static
    {
        return $this->has('comments');
    }
}
