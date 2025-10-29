<?php

namespace App\Models;

use App\Models\Builders\GenreQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperGenre
 */
class Genre extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'book_count',
    ];

    protected $casts = [
        'parent_id' => 'string',
        'book_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): GenreQueryBuilder
    {
        return new GenreQueryBuilder($query);
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Genre::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Genre::class, 'parent_id');
    }

    public function subgenres(): HasMany
    {
        return $this->children();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'description' => $this->description,
            'book_count' => $this->book_count,
            'book_ids' => $this->books()->pluck('books.id')->toArray(),
        ];
    }

    public function searchableAs(): string
    {
        return 'genres';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'parent_id',
                'book_count',
            ],
            'sortableAttributes' => ['name', 'book_count', 'created_at'],
        ];
    }
}
