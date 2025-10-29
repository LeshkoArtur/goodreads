<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class NoteQueryBuilder extends Builder
{
    /**
     * Нотатки від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Нотатки для певної книги.
     */
    public function forBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Нотатки, що містять спойлери.
     */
    public function withSpoilers(): static
    {
        return $this->where('contains_spoilers', true);
    }

    /**
     * Публічні нотатки.
     */
    public function isPublic(): static
    {
        return $this->where('is_private', false);
    }

    /**
     * Нотатки з певним текстом (частковий збіг).
     */
    public function withText(string $text): static
    {
        return $this->where('text', 'like', '%'.$text.'%');
    }
}
