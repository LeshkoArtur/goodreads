<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class PublisherQueryBuilder extends Builder
{
    /**
     * Видавці з певною назвою (частковий збіг).
     */
    public function withName(string $name): static
    {
        return $this->where('name', 'like', '%'.$name.'%');
    }

    /**
     * Видавці з певної країни.
     */
    public function fromCountry(string $country): static
    {
        return $this->where('country', $country);
    }

    /**
     * Видавці, засновані після певного року.
     */
    public function foundedAfter(int $year): static
    {
        return $this->where('founded_year', '>', $year);
    }

    /**
     * Видавці, що видали певну книгу.
     */
    public function withBook(string $bookId): static
    {
        return $this->whereHas('books', fn ($q) => $q->where('id', $bookId));
    }

    /**
     * Видавці з вебсайтом.
     */
    public function withWebsite(): static
    {
        return $this->whereNotNull('website');
    }
}
