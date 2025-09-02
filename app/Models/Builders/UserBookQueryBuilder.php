<?php

namespace App\Models\Builders;

use App\Enums\ReadingFormat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class UserBookQueryBuilder extends Builder
{
    /**
     * Книги, додані певним користувачем.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Книги на певній полиці.
     */
    public function onShelf(string $shelfId): static
    {
        return $this->where('shelf_id', $shelfId);
    }

    /**
     * Книги з певною книгою.
     */
    public function forBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Книги, прочитані після певної дати.
     */
    public function readAfter(Carbon $date): static
    {
        return $this->where('read_date', '>', $date->toDateString());
    }

    /**
     * Книги з певним форматом читання.
     */
    public function withReadingFormat(ReadingFormat $format): static
    {
        return $this->where('reading_format', $format);
    }

    /**
     * Публічні записи.
     */
    public function isPublic(): static
    {
        return $this->where('is_private', false);
    }

    /**
     * Книги з оцінкою.
     */
    public function withRating(): static
    {
        return $this->whereNotNull('rating');
    }
}
