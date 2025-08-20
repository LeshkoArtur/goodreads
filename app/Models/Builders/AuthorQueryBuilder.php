<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class AuthorQueryBuilder extends Builder
{
    /**
     * Автори, які ще живі
     */
    public function alive(): static
    {
        return $this->whereNull('death_date');
    }

    /**
     * Автори, які вже померли
     */
    public function deceased(): static
    {
        return $this->whereNotNull('death_date');
    }

    /**
     * Автори з конкретною національністю
     */
    public function withNationality(string $nationality): static
    {
        return $this->where('nationality', $nationality);
    }

    /**
     * Автори, народжені після певної дати
     */
    public function bornAfter(Carbon $date): static
    {
        return $this->whereDate('birth_date', '>', $date->toDateString());
    }

    /**
     * Автори, що мають вказаний тип роботи
     */
    public function withTypeOfWork(string $type): static
    {
        return $this->where('type_of_work', $type);
    }

    /**
     * Автори, що пов'язані з конкретною книгою
     */
    public function whereHasBook(string $bookId): static
    {
        return $this->whereHas('books', fn ($q) => $q->where('id', $bookId));
    }

    /**
     * Автори, що мають профільну картинку
     */
    public function withProfilePicture(): static
    {
        return $this->whereNotNull('profile_picture');
    }

    /**
     * Автори, в яких є хоча б один пост
     */
    public function withPosts(): static
    {
        return $this->has('posts');
    }
}
