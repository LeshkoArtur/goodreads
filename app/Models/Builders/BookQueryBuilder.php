<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class BookQueryBuilder extends Builder
{
    /**
     * Книги, що є бестселерами.
     */
    public function bestseller(): static
    {
        return $this->where('is_bestseller', true);
    }

    /**
     * Книги з рейтингом не нижче заданого.
     */
    public function withMinRating(float $rating): static
    {
        return $this->where('average_rating', '>=', $rating);
    }

    /**
     * Книги з певним віковим обмеженням.
     * Якщо обмеження не вказане — фільтр не застосовується.
     */
    public function withAgeRestriction(?string $restriction): static
    {
        return $restriction
            ? $this->where('age_restriction', $restriction)
            : $this;
    }

    /**
     * Книги, що входять до серії з вказаним ID.
     */
    public function inSeries(string $seriesId): static
    {
        return $this->where('series_id', $seriesId);
    }

    /**
     * Книги, що містять хоча б одну з вказаних мов.
     */
    public function withLanguages(array $languages): static
    {
        return $this->whereJsonContains('languages', $languages);
    }

    /**
     * Книги, що були опубліковані в певному діапазоні дат
     * через пов'язану модель "publishers".
     */
    public function publishedBetween(?Carbon $from, ?Carbon $to): static
    {
        return $this->whereHas('publishers', function ($q) use ($from, $to) {
            if ($from) {
                $q->where('published_date', '>=', $from->toDateString());
            }
            if ($to) {
                $q->where('published_date', '<=', $to->toDateString());
            }
        });
    }

    /**
     * Книги, що належать до певного жанру (genre_id).
     */
    public function withGenre(string $genreId): static
    {
        return $this->whereHas('genres', fn ($q) => $q->where('id', $genreId));
    }

    /**
     * Книги, написані певним автором (author_id).
     */
    public function withAuthor(string $authorId): static
    {
        return $this->whereHas('authors', fn ($q) => $q->where('id', $authorId));
    }
}
