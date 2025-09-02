<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;

class CharacterQueryBuilder extends Builder
{
    /**
     * Персонажі з певної книги.
     */
    public function fromBook(string $bookId): static
    {
        return $this->where('book_id', $bookId);
    }

    /**
     * Персонажі з певним ім’ям (частковий збіг).
     */
    public function withName(string $name): static
    {
        return $this->where('name', 'like', '%' . $name . '%');
    }

    /**
     * Персонажі певної раси.
     */
    public function withRace(string $race): static
    {
        return $this->where('race', $race);
    }

    /**
     * Персонажі з певною національністю.
     */
    public function withNationality(string $nationality): static
    {
        return $this->where('nationality', $nationality);
    }

    /**
     * Персонажі з цікавими фактами.
     */
    public function withFunFacts(): static
    {
        return $this->whereNotNull('fun_facts');
    }
}
