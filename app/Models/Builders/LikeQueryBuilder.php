<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class LikeQueryBuilder extends Builder
{
    /**
     * Лайки від певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Лайки для певної сутності (likeable).
     */
    public function forLikeable(string $type, string $id): static
    {
        return $this->where('likeable_type', $type)->where('likeable_id', $id);
    }
}
