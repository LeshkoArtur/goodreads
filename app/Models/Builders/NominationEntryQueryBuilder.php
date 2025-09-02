<?php

namespace App\Models\Builders;

use App\Enums\NominationStatus;
use Illuminate\Database\Eloquent\Builder;

class NominationEntryQueryBuilder extends Builder
{
    /**
     * Записи номінацій для певної номінації.
     */
    public function forNomination(string $nominationId): static
    {
        return $this->where('nomination_id', $nominationId);
    }

    /**
     * Записи номінацій для певної книги.
     */
    public function forBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Записи номінацій для певного автора.
     */
    public function forAuthor(string $authorId): static
    {
        return $this->where('author_id', $authorId);
    }

    /**
     * Записи номінацій з певним статусом.
     */
    public function withStatus(NominationStatus $status): static
    {
        return $this->where('status', $status);
    }
}
