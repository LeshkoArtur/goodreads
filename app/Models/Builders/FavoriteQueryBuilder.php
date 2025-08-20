<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class FavoriteQueryBuilder extends Builder
{
    /**
     * Вибране, додане певним користувачем.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Вибране для певної сутності (favoriteable).
     */
    public function forFavoriteable(string $type, string $id): static
    {
        return $this->where('favoriteable_type', $type)->where('favoriteable_id', $id);
    }
}
