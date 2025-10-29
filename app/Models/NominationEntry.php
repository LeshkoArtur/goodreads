<?php

namespace App\Models;

use App\Enums\NominationStatus;
use App\Models\Builders\NominationEntryQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperNominationEntry
 */
class NominationEntry extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'nomination_id',
        'book_id',
        'author_id',
        'status',
    ];

    protected $casts = [
        'status' => NominationStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): NominationEntryQueryBuilder
    {
        return new NominationEntryQueryBuilder($query);
    }

    public function nomination(): BelongsTo
    {
        return $this->belongsTo(Nomination::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'nomination_id' => $this->nomination_id,
            'book_id' => $this->book_id,
            'author_id' => $this->author_id,
            'status' => $this->status,
        ];
    }

    public function searchableAs(): string
    {
        return 'nomination_entries';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'nomination_id',
                'book_id',
                'author_id',
                'status',
            ],
            'sortableAttributes' => ['created_at'],
        ];
    }
}
