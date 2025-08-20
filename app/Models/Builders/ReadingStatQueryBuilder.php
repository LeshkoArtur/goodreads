<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ReadingStatQueryBuilder extends Builder
{
    /**
     * Статистика для певного користувача.
     */
    public function forUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Статистика за певний рік.
     */
    public function forYear(int $year): static
    {
        return $this->where('year', $year);
    }

    /**
     * Статистика з мінімальною кількістю прочитаних книг.
     */
    public function minBooksRead(int $count): static
    {
        return $this->where('books_read', '>=', $count);
    }

    /**
     * Статистика з мінімальною кількістю прочитаних сторінок.
     */
    public function minPagesRead(int $count): static
    {
        return $this->where('pages_read', '>=', $count);
    }

    /**
     * Статистика з певними жанрами.
     */
    public function withGenres(array $genres): static
    {
        return $this->whereJsonContains('genres_read', $genres);
    }
}
