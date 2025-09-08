<?php

namespace App\Models;

use App\Enums\ReadingFormat;
use App\Models\Builders\UserBookQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperUserBook
 */
class UserBook extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'book_id',
        'shelf_id',
        'start_date',
        'read_date',
        'progress_pages',
        'is_private',
        'rating',
        'notes',
        'reading_format',
    ];

    protected $casts = [
        'start_date' => 'date',
        'read_date' => 'date',
        'is_private' => 'boolean',
        'rating' => 'integer',
        'reading_format' => ReadingFormat::class,
    ];

    public function newEloquentBuilder($query): UserBookQueryBuilder
    {
        return new UserBookQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'shelf_id' => $this->shelf_id,
            'start_date' => $this->start_date,
            'read_date' => $this->read_date,
            'progress_pages' => $this->progress_pages,
            'is_private' => $this->is_private,
            'rating' => $this->rating,
            'notes' => $this->notes,
            'reading_format' => $this->reading_format,
        ];
    }

    public function searchableAs(): string
    {
        return 'user_books';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'book_id',
                'shelf_id',
            ],
            'sortableAttributes' => ['created_at', 'start_date', 'read_date', 'progress_pages', 'rating'],
        ];
    }
}
