<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CollectionQueryBuilder extends Builder
{
    /**
     * Колекції, що належать певному користувачу.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Публічні колекції.
     */
    public function isPublic(): static
    {
        return $this->where('is_public', true);
    }

    /**
     * Колекції з певною назвою (частковий збіг).
     */
    public function withTitle(string $title): static
    {
        return $this->where('title', 'like', '%'.$title.'%');
    }

    /**
     * Колекції, що містять певну книгу.
     */
    public function withBook(string $bookId): static
    {
        return $this->whereHas('books', fn ($q) => $q->where('id', $bookId));
    }

    /**
     * Колекції з обкладинкою.
     */
    public function withCoverImage(): static
    {
        return $this->whereNotNull('cover_image');
    }
}
