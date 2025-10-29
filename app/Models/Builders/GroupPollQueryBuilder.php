<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class GroupPollQueryBuilder extends Builder
{
    /**
     * Опитування для певної групи.
     */
    public function forGroup(string $groupId): static
    {
        return $this->where('group_id', $groupId);
    }

    /**
     * Опитування, створені певним користувачем.
     */
    public function byCreator(string $creatorId): static
    {
        return $this->where('creator_id', $creatorId);
    }

    /**
     * Активні опитування.
     */
    public function isActive(): static
    {
        return $this->where('is_active', true);
    }

    /**
     * Опитування з певним питанням (частковий збіг).
     */
    public function withQuestion(string $question): static
    {
        return $this->where('question', 'like', '%'.$question.'%');
    }

    /**
     * Опитування з голосами.
     */
    public function withVotes(): static
    {
        return $this->has('votes');
    }
}
