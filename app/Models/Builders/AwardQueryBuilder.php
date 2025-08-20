<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class AwardQueryBuilder extends Builder
{
    /**
     * Нагороди за певний рік.
     */
    public function fromYear(int $year): static
    {
        return $this->where('year', $year);
    }

    /**
     * Нагороди від певного організатора.
     */
    public function byOrganizer(string $organizer): static
    {
        return $this->where('organizer', $organizer);
    }

    /**
     * Нагороди з певної країни.
     */
    public function fromCountry(string $country): static
    {
        return $this->where('country', $country);
    }

    /**
     * Нагороди з церемонією після певної дати.
     */
    public function ceremonyAfter(Carbon $date): static
    {
        return $this->where('ceremony_date', '>', $date->toDateString());
    }

    /**
     * Нагороди, що мають номінації.
     */
    public function withNominations(): static
    {
        return $this->has('nominations');
    }
}
