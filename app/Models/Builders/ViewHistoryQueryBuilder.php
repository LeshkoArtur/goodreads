<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class ViewHistoryQueryBuilder extends Builder
{
    /**
     * Історія переглядів для певного користувача.
     */
    public function byUser(string $userId): static
    {
        return $this->where('user_id', $userId);
    }

    /**
     * Історія переглядів для певної сутності (viewable).
     */
    public function forViewable(string $type, string $id): static
    {
        return $this->where('viewable_type', $type)->where('viewable_id', $id);
    }
}
