<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class BookSeriesQueryBuilder extends Builder
{
    /**
     * Серії з певною назвою (частковий збіг).
     */
    public function withTitle(string $title): static
    {
        return $this->where('title', 'like', '%'.$title.'%');
    }

    /**
     * Завершені серії.
     */
    public function completed(): static
    {
        return $this->where('is_completed', true);
    }

    /**
     * Серії з мінімальною кількістю книг.
     */
    public function minBooks(int $count): static
    {
        return $this->where('total_books', '>=', $count);
    }

    /**
     * Серії, що містять книги.
     */
    public function withBooks(): static
    {
        return $this->has('books');
    }

    /**
     * Серії, що містять певну книгу.
     */
    public function hasBook(string $bookId): static
    {
        return $this->whereHas('books', fn ($q) => $q->where('id', $bookId));
    }
}
