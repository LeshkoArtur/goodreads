<?php

namespace App\Models\Builders;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class BookOfferQueryBuilder extends Builder
{
    /**
     * Пропозиції для певної книги.
     */
    public function forBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Пропозиції від певного магазину.
     */
    public function fromStore(string $storeId): static
    {
        return $this->where('store_id', $storeId);
    }

    /**
     * Пропозиції з певною валютою.
     */
    public function withCurrency(Currency $currency): static
    {
        return $this->where('currency', $currency);
    }

    /**
     * Пропозиції з певним статусом.
     */
    public function withStatus(OfferStatus $status): static
    {
        return $this->where('status', $status);
    }

    /**
     * Пропозиції з ціною, меншою або рівною заданій.
     */
    public function maxPrice(float $price): static
    {
        return $this->where('price', '<=', $price);
    }

    /**
     * Пропозиції, оновлені після певної дати.
     */
    public function updatedAfter(Carbon $date): static
    {
        return $this->where('last_updated_at', '>', $date->toDateTimeString());
    }
}
