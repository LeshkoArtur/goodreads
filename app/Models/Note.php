<?php

namespace App\Models;

use App\Models\Builders\NoteQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperNote
 */
class Note extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'book_id',
        'text',
        'page_number',
        'contains_spoilers',
        'is_private',
    ];

    protected $casts = [
        'contains_spoilers' => 'boolean',
        'is_private' => 'boolean',
    ];

    public function newEloquentBuilder($query): NoteQueryBuilder
    {
        return new NoteQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'text' => $this->text,
            'page_number' => $this->page_number,
            'contains_spoilers' => $this->contains_spoilers,
            'is_private' => $this->is_private,
        ];
    }

    public function searchableAs(): string
    {
        return 'notes';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'book_id',
                'contains_spoilers',
                'is_private',
                'page_number',
            ],
            'sortableAttributes' => ['created_at', 'page_number'],
        ];
    }
}
