<?php

namespace App\Models\Builders;

use App\Enums\JoinPolicy;
use App\Enums\PostPolicy;
use Illuminate\Database\Eloquent\Builder;

class GroupQueryBuilder extends Builder
{
    /**
     * Публічні групи.
     */
    public function isPublic(): static
    {
        return $this->where('is_public', true);
    }

    /**
     * Активні групи.
     */
    public function isActive(): static
    {
        return $this->where('is_active', true);
    }

    /**
     * Групи, створені певним користувачем.
     */
    public function byCreator(string $creatorId): static
    {
        return $this->where('creator_id', $creatorId);
    }

    /**
     * Групи з певною назвою (частковий збіг).
     */
    public function withName(string $name): static
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Групи з мінімальною кількістю учасників.
     */
    public function minMembers(int $count): static
    {
        return $this->where('member_count', '>=', $count);
    }

    /**
     * Групи з певною політикою приєднання.
     */
    public function withJoinPolicy(JoinPolicy $policy): static
    {
        return $this->where('join_policy', $policy);
    }

    /**
     * Групи з певною політикою публікацій.
     */
    public function withPostPolicy(PostPolicy $policy): static
    {
        return $this->where('post_policy', $policy);
    }

    /**
     * Групи, що містять певного учасника.
     */
    public function withMember(string $userId): static
    {
        return $this->whereHas('members', fn ($q) => $q->where('id', $userId));
    }
}
