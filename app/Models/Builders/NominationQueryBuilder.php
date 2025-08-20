<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class NominationQueryBuilder extends Builder
{
    /**
     * Номінації для певної нагороди.
     */
    public function forAward(string $awardId): static
    {
        return $this->where('award_id', $awardId);
    }

    /**
     * Номінації з певною назвою (частковий збіг).
     */
    public function withName(string $name): static
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Номінації з записами.
     */
    public function withEntries(): static
    {
        return $this->has('entries');
    }
}
