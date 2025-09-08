<?php

namespace App\Models;

use App\Models\Builders\CollectionQueryBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

/**
 * @mixin IdeHelperCollection
 */
class Collection extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'cover_image',
        'is_public',
    ];

    protected $casts = [
        'user_id' => 'string',
        'is_public' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function newEloquentBuilder($query): CollectionQueryBuilder
    {
        return new CollectionQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_collection')->withPivot('order_index');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'is_public' => $this->is_public,
            'book_ids' => $this->books()->pluck('books.id')->toArray(),
        ];
    }

    public function searchableAs(): string
    {
        return 'collections';
    }

    public function scoutMetadata(): array
    {
        return [
            'filterableAttributes' => [
                'user_id',
                'is_public',
                'book_ids',
            ],
            'sortableAttributes' => ['title', 'created_at'],
        ];
    }
}
