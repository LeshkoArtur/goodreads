<?php

namespace App\Models\Builders;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PostQueryBuilder extends Builder
{
    /**
     * Пости від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Пости для певної книги.
     */
    public function forBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Пости про певного автора.
     */
    public function forAuthor(string $authorId): static
    {
        return $this->where('author_id', $authorId);
    }

    /**
     * Пости з певним типом.
     */
    public function withType(PostType $type): static
    {
        return $this->where('type', $type);
    }

    /**
     * Пости з певним статусом.
     */
    public function withStatus(PostStatus $status): static
    {
        return $this->where('status', $status);
    }

    /**
     * Пости, опубліковані після певної дати.
     */
    public function publishedAfter(Carbon $date): static
    {
        return $this->where('published_at', '>', $date->toDateTimeString());
    }

    /**
     * Пости з коментарями.
     */
    public function withComments(): static
    {
        return $this->has('comments');
    }

    /**
     * Пости з тегами.
     */
    public function withTags(): static
    {
        return $this->has('tags');
    }
}
