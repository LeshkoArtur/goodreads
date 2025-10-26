<?php

namespace App\Models;

use App\Models\Builders\ReadingStatQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperReadingStat
 */
class ReadingStat extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'year',
        'books_read',
        'pages_read',
        'genres_read',
    ];

    protected $casts = [
        'year' => 'integer',
        'books_read' => 'integer',
        'pages_read' => 'integer',
        'genres_read' => 'array',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): ReadingStatQueryBuilder
    {
        return new ReadingStatQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'year' => $this->year,
            'books_read' => $this->books_read,
            'pages_read' => $this->pages_read,
            'genres_read' => $this->genres_read,
        ];
    }

    public function searchableAs(): string
    {
        return 'reading_stats';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'year',
                'pages_read',
                'genres_read',
            ],
            'sortableAttributes' => ['created_at', 'year', 'books_read', 'pages_read'],
        ];
    }
}
