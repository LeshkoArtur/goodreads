<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class GenreQueryBuilder extends Builder
{
    /**
     * Жанри з певною назвою (частковий збіг).
     */
    public function withName(string $name): static
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Піджанри певного батьківського жанру.
     */
    public function subGenres(string $parentId): static
    {
        return $this->where('parent_id', $parentId);
    }

    /**
     * Жанри верхнього рівня (без батьківського жанру).
     */
    public function topLevel(): static
    {
        return $this->whereNull('parent_id');
    }

    /**
     * Жанри з мінімальною кількістю книг.
     */
    public function minBooks(int $count): static
    {
        return $this->where('book_count', '>=', $count);
    }

    /**
     * Жанри, що містять певну книгу.
     */
    public function withBook(string $bookId): static
    {
        return $this->whereHas('books', fn ($q) => $q->where('id', $bookId));
    }
}
