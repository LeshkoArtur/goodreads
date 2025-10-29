<?php

namespace App\Models;

use App\Enums\AgeRestriction;
use App\Models\Builders\BookQueryBuilder;
use App\Models\Traits\HasFiles;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperBook
 */
class Book extends Model
{
    use HasFactory, HasFiles, HasUuids, Searchable;

    protected $fillable = [
        'title',
        'description',
        'plot',
        'history',
        'series_id',
        'number_in_series',
        'page_count',
        'languages',
        'cover_image',
        'fun_facts',
        'adaptations',
        'is_bestseller',
        'average_rating',
        'age_restriction',
    ];

    protected $casts = [
        'series_id' => 'string',
        'number_in_series' => 'integer',
        'page_count' => 'integer',
        'languages' => AsCollection::class,
        'fun_facts' => AsCollection::class,
        'adaptations' => AsCollection::class,
        'is_bestseller' => 'boolean',
        'average_rating' => 'decimal:2',
        'age_restriction' => AgeRestriction::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): BookQueryBuilder
    {
        return new BookQueryBuilder($query);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_book');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function publishers(): BelongsToMany
    {
        return $this->belongsToMany(Publisher::class, 'book_publisher')
            ->using(BookPublisher::class)
            ->withPivot([
                'published_date',
                'isbn',
                'circulation',
                'format',
                'cover_type',
                'translator',
                'edition',
                'price',
                'binding',
            ]);
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(BookSeries::class, 'series_id');
    }

    public function userBooks(): HasMany
    {
        return $this->hasMany(UserBook::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function nominationEntries(): HasMany
    {
        return $this->hasMany(NominationEntry::class);
    }

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'book_collection')
            ->withPivot('order_index');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AuthorQuestion::class);
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'plot' => $this->plot,
            'history' => $this->history,
            'languages' => $this->languages,
            'is_bestseller' => $this->is_bestseller,
            'average_rating' => $this->average_rating,
            'age_restriction' => $this->age_restriction,
            'series_id' => $this->series_id,
            'page_count' => $this->page_count,
            'author_ids' => $this->authors()->pluck('authors.id')->toArray(),
            'genre_ids' => $this->genres()->pluck('genres.id')->toArray(),
            'publisher_ids' => $this->publishers()->pluck('publishers.id')->toArray(),
        ];
    }

    public function searchableAs(): string
    {
        return 'books';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'is_bestseller',
                'average_rating',
                'age_restriction',
                'languages',
                'series_id',
                'page_count',
                'author_ids',
                'genre_ids',
                'publisher_ids',
            ],
            'sortableAttributes' => ['average_rating', 'page_count', 'created_at'],
        ];
    }
}
