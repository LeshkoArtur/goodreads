<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class StoreQueryBuilder extends Builder
{
    /**
     * Магазини з певною назвою (частковий збіг).
     */
    public function withName(string $name): static
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Магазини з певного регіону.
     */
    public function fromRegion(string $region): static
    {
        return $this->where('region', $region);
    }

    /**
     * Магазини з пропозиціями книг.
     */
    public function withBookOffers(): static
    {
        return $this->has('bookOffers');
    }

    /**
     * Магазини з вебсайтом.
     */
    public function withWebsite(): static
    {
        return $this->whereNotNull('website_url');
    }
}
