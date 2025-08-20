<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CommentQueryBuilder extends Builder
{
    /**
     * Коментарі від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Коментарі до певної сутності (commentable).
     */
    public function forCommentable(string $type, string $id): static
    {
        return $this->where('commentable_type', $type)->where('commentable_id', $id);
    }

    /**
     * Коментарі верхнього рівня (без батьківського коментаря).
     */
    public function topLevel(): static
    {
        return $this->whereNull('parent_id');
    }

    /**
     * Коментарі, що мають відповіді.
     */
    public function withReplies(): static
    {
        return $this->has('replies');
    }

    /**
     * Коментарі, що містять певний текст (частковий збіг).
     */
    public function withContent(string $content): static
    {
        return $this->where('content', 'like', '%' . $content . '%');
    }
}
