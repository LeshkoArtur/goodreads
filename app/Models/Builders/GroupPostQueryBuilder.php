<?php

namespace App\Models\Builders;

use App\Enums\PostCategory;
use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Builder;

class GroupPostQueryBuilder extends Builder
{
    /**
     * Пости для певної групи.
     */
    public function forGroup(string $groupId): static
    {
        return $this->where('group_id', $groupId);
    }

    /**
     * Пости від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Закріплені пости.
     */
    public function isPinned(): static
    {
        return $this->where('is_pinned', true);
    }

    /**
     * Пости з певною категорією.
     */
    public function withCategory(PostCategory $category): static
    {
        return $this->where('category', $category);
    }

    /**
     * Пости з певним статусом.
     */
    public function withStatus(PostStatus $status): static
    {
        return $this->where('post_status', $status);
    }

    /**
     * Пости з коментарями.
     */
    public function withComments(): static
    {
        return $this->has('comments');
    }

    /**
     * Пости з лайками.
     */
    public function withLikes(): static
    {
        return $this->has('likes');
    }
}
