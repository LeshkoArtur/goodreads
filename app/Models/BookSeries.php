<?php

namespace App\Models;

use App\Models\Builders\BookSeriesQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperBookSeries
 */
class BookSeries extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'title',
        'description',
        'total_books',
        'is_completed',
    ];

    public function newEloquentBuilder($query): BookSeriesQueryBuilder
    {
        return new BookSeriesQueryBuilder($query);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'series_id');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'total_books' => $this->total_books,
            'is_completed' => $this->is_completed,
        ];
    }

    public function searchableAs(): string
    {
        return 'book_series';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'total_books',
                'is_completed',
            ],
            'sortableAttributes' => ['title', 'total_books', 'created_at'],
        ];
    }
}
