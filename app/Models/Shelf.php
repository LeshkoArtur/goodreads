<?php

namespace App\Models;

use App\Models\Builders\ShelfQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperShelf
 */
class Shelf extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'name',
    ];

    protected $casts = [
        'name' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): ShelfQueryBuilder
    {
        return new ShelfQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userBooks(): HasMany
    {
        return $this->hasMany(UserBook::class);
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'user_books', 'shelf_id', 'book_id')
            ->withPivot([
                'user_id',
                'start_date',
                'read_date',
                'progress_pages',
                'is_private',
                'rating',
                'notes',
                'reading_format',
                'created_at',
                'updated_at',
            ])
            ->withTimestamps();
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
        ];
    }

    public function searchableAs(): string
    {
        return 'shelves';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
            ],
            'sortableAttributes' => ['created_at', 'name'],
        ];
    }
}
